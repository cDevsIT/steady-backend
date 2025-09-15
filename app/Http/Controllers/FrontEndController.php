<?php

namespace App\Http\Controllers;

use App\Custom\BlogSEOSchema;
use App\Jobs\TicketCommandJob;
use App\Jobs\TicketJob;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\GetInTouch;
use App\Models\Order;
use App\Models\PostTag;
use App\Models\StateFee;
use App\Models\Tag;
use App\Models\Ticket;
use App\Models\User;
use App\Services\SeoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use NunoMaduro\Collision\Adapters\Phpunit\State;

class FrontEndController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function home()
    {


        $metaData = new BlogSEOSchema(
            "Home - Steady Formation",
            "At Steady Formation, our philosophy is rooted in a deep commitment to breaking down barriers for global entrepreneurs. With 7+ years of expertise in business",
            'Steady Formation',
            Carbon::parse("2024-07-13"),
            now(),
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);
        $posts = Blog::latest()->take(3)->get();
        $state_fees = StateFee::orderBy('state_name')->pluck('fees', 'state_name')->toArray();
        $states = ['Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'];
        return view('web.home.home', compact('state_fees', 'posts', 'seo','states'));
    }

    public function dashboard()
    {

        $activeCompany = session('active_company_id');
        $company = Company::where("id", $activeCompany)->where('user_id', Auth::id())->first();

        if (!$company) {
            session()->forget('active_company_id');
            $company = Company::where('user_id', Auth::id())->latest()->first();
        }
        if (!$company) {
            return redirect()->route('web.home')->with("First Add Company to see Dashboard");
        }

        return redirect()->route('web.companies', compact('company'));
    }

    public function companies(Company $company)
    {
        session(["active_company_id" => $company->id]);
//        $data['companies'] = Company::where('user_id', Auth::id())->select('company_name', 'business_type', 'id')->orderBy('created_at', 'DESC')->get();
        $data['order'] = $order = Order::where('company_id', $company->id)->first();
        if (!$order) {
            return redirect()->route('web.home')->with("First Make A Order");
        }
        $data['company'] = $company;
        if ($company->user_id != Auth::id()){
            abort(404);
        }

        return view('web.dashboard.dashboard', $data);
    }

    public function aboutUs()
    {
        $metaData = new BlogSEOSchema(
            "About Us of Steady Formation",
            "At Steady Formation, we help people from all over start their businesses in the US easily. Our experienced team is here to guide you through every step, from getting your company set up to making sure everything’s done right.",
            'Steady Formation',
            Carbon::parse("2024-07-13"),
            now(),
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);

        return view('web.about_us', compact('seo'));
    }

    public function contactUs()
    {
        $metaData = new BlogSEOSchema(
            "Contact Us of Steady Formation",
            "Contact our expert support team. Ask query to our team and get solutions 24/7 from anywhere. emails at info@steadyformation.com",
            'Steady Formation',
            Carbon::parse("2024-07-13"),
            now(),
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);

        return view('web.contact_us', compact('seo'));
    }

    public function getInTouch(Request $request)
    {
        $touch = new GetInTouch;
        $touch->name = $request->name;
        $touch->email = $request->email;
        $touch->subject = $request->subject;
        $touch->message = $request->message;
        $touch->addedBy = Auth::id();
        $touch->save();
        return redirect()->route('web.contact_us')->with('success', 'Thank you for contacting us. We will get back to you soon.');
    }

    public function tramsAndCondition()
    {
        $metaData = new BlogSEOSchema(
            "Terms and Conditions of Steady Formation",
            "These Terms of Service (“Terms,” “Terms of Service”) govern your use of our website located at https://steadyformation.com (together or individually “Service”) operated by Steady Formation.",
            'Steady Formation',
            Carbon::parse("2024-07-13"),
            now(),
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);

        return view('web.terms_and_conditions', compact('seo'));
    }

    public function privacyPolicy()
    {
        $metaData = new BlogSEOSchema(
            "Privacy Policies of Steady Formation",
            "Our Privacy Policy governs your visit to steadyformation.com and explains how we collect, safeguard, and disclose information that results from your use of our service.",
            'Steady Formation',
            Carbon::parse("2024-07-13"),
            now(),
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);
        return view('web.privacy_policy', compact('seo'));
    }

    public function returnPolicy()
    {
        $metaData = new BlogSEOSchema(
            "Refund Policies of Steady Formation",
            "Purchasing digital services & products, including PDF downloads and online material, is subject to the following terms and conditions. Consumers are advised to review carefully before making any purchase.",
            'Steady Formation',
            Carbon::parse("2024-07-13"),
            now(),
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);

        return view('web.return_policy', compact('seo'));
    }

    public function blogs(Request $request)
    {

        $metaData = new BlogSEOSchema(
            "Blog - Steady Formation",
            "Explore insightful articles on personal growth, productivity hacks, and self-improvement strategies at Steady Formation. Discover practical tips to enhance your journey towards achieving personal and professional success",
            "mannaf",
            now(),
            now(),
            false
        );

        $seo = $this->seoService->generateSeoData($metaData);
        $posts = Blog::latest()->where(function ($q) use ($request) {
            if ($request->q) {
                $q->where('title', 'like', '%' . $request->q . '%');
            }
        })->paginate(10);
        return view('web.blog.blogs', compact('posts', 'seo'));
    }


    public function post(Request $request)
    {
        $post = Blog::findBySlugOrFail($request->slug);
        $categories = Category::orderBy('title')->get();
        $relatedPosts = Blog::where('id', '!=', $post->id)->take(3)->get();

        $metaData = new BlogSEOSchema(
            $post->meta_title ?: $post->title,
            $post->meta_description ?: $post->description,
            $post->author ? $post->full_name : 'Admin',
            $post->created_at,
            $post->updated_at,
            true
        );
        $seo = $this->seoService->generateSeoData($metaData);


        return view('web.blog.single_view', compact('post', 'relatedPosts', 'categories', 'seo'));
    }

    public function categoryPosts(Request $request)
    {
        $category = Category::findBySlugOrFail($request->slug);
        $posts = $category->posts()->paginate(10);

        $metaData = new BlogSEOSchema(
            $category->meta_title ?: $category->title . ' | ' . env('APP_NAME'),
            $category->meta_description ?: $category->title . ' | ' . env('APP_NAME'),
            $category->addedBy ? $category->full_name : 'Admin',
            $category->created_at,
            $category->updated_at,
            false
        );
        $seo = $this->seoService->generateSeoData($metaData);

        return view('web.blog.category_view', compact('posts', 'category', 'seo'));
    }

    public function tagPosts(Request $request)
    {
        $tag = Tag::findBySlugOrFail($request->slug);
        $posts = $tag->posts()->paginate(10);

        $metaData = new BlogSEOSchema(
            $tag->title . ' | ' . env('APP_NAME'),
            "Post of " . $tag->title . ' | ' . env('APP_NAME'),
            'Admin',
            $tag->created_at,
            $tag->updated_at,
            false
        );
        $seo = $this->seoService->generateSeoData($metaData);

        return view('web.blog.tag_view', compact('posts', 'tag', 'seo'));
    }

    public function authorPosts(Request $request)
    {
        $author = User::findBySlugOrFail($request->slug);
        $posts = $author->posts()->paginate(10);

        $metaData = new BlogSEOSchema(
            $author->full_name . ' | ' . env('APP_NAME'),
            "Post of " . $author->full_name . ' | ' . env('APP_NAME'),
            $author->full_name ?: 'Admin',
            $author->created_at,
            $author->updated_at,
            false
        );
        $seo = $this->seoService->generateSeoData($metaData);
        return view('web.blog.author_view', compact('posts', 'author', 'seo'));
    }

    public function tickets(Company $company, Request $request)
    {
        if ($company->user_id != Auth::id()){
            abort(404);
        }
        menuSubmenu('tickets', 'tickets');
        $paginate = 30;
        $tickets = Ticket::orderBy('id', 'DESC')
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->where('tickets.user_id', Auth::id())
            ->select('tickets.id', 'tickets.title', 'tickets.status', 'tickets.file_name', 'users.first_name', 'users.last_name', 'users.email', 'users.phone')
            ->paginate($paginate);

        return view('web.dashboard.tickets.tickets', compact('tickets'))->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    public function makeTicket(Request $request)
    {

        if ($request->method() == 'POST') {
            $request->validate([
                'title' => 'required|max:255',
                'message' => 'required',
                'file' => 'sometimes|file|mimes:jpeg,png,jpg,gif,pdf'
            ]);

            $ticket = new Ticket();
            $ticket->title = $request->title;
            $ticket->content = $request->message;
            $ticket->company_id = session('active_company_id');
            $ticket->user_id = Auth::id();

            if ($request->hasFile('attachment')) {
                $thumbnail_path = 'uploads/tickets';
                if (!Storage::disk('public')->directoryExists($thumbnail_path)) {
                    Storage::disk('public')->makeDirectory($thumbnail_path);
                }
                $file = $request->file('attachment');
                $filenameWithExt = $file->getClientOriginalName();
                $generate_name = time() . $filenameWithExt;
                $fileNameToStore = $thumbnail_path . "/" . $generate_name;
                $file_with_path = 'uploads/tickets' . $generate_name;

                Storage::disk("public")->put($fileNameToStore, file_get_contents($request->file('attachment')));
                $filePath = url(Storage::url($fileNameToStore));

                $ticket->file_name = $fileNameToStore;

            }

            $ticket->save();
            $user = User::where('role', '1')->get();
            $route = route('tickets.show', $ticket);
            TicketJob::dispatch($ticket, $route, $user);

            return redirect()->route('web.tickets',$ticket->company_id)->with('success', 'Ticket has been created successfully.');
        }

        return view('web.dashboard.tickets.make-a-ticket');
    }

    public function viewTicket(Ticket $ticket, Request $request)
    {
        if ($ticket->user_id != Auth::id()){
            abort(404);
        }
        $ticket = Ticket::where('tickets.id', $ticket->id)
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->select('tickets.id', 'tickets.title', 'tickets.status', 'tickets.content', 'tickets.file_name', 'users.first_name', 'users.last_name', 'users.email', 'users.phone','users.role')->first();

        $comments = Comment::where('comments.ticket_id', $ticket->id)
            ->leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'comments.comment_text', 'comments.created_at', "comments.attachment",'users.first_name', 'users.last_name', 'users.email', 'users.phone','users.role')
            ->orderBy('comments.id', 'ASC')->get();
        return view('web.dashboard.tickets.view', compact('ticket', 'comments'));
    }

    public function makeComment(Ticket $ticket, Request $request)
    {
        if ($ticket->user_id != Auth::id()){
            abort(404);
        }
        $comment = new Comment;
        $comment->comment_text = $request->comment_text;
        $comment->ticket_id = $ticket->id;
        $comment->user_id = Auth::id();
        if ($request->hasFile('attachment')) {
            $thumbnail_path = 'uploads/tickets/comment';
            if (!Storage::disk('public')->directoryExists($thumbnail_path)) {
                Storage::disk('public')->makeDirectory($thumbnail_path);
            }
            $file = $request->file('attachment');
            $filenameWithExt = $file->getClientOriginalName();
            $generate_name = time() . $filenameWithExt;
            $fileNameToStore = $thumbnail_path . "/" . $generate_name;
            $file_with_path = 'uploads/tickets/comment' . $generate_name;

            Storage::disk("public")->put($fileNameToStore, file_get_contents($request->file('attachment')));
            $filePath = url(Storage::url($fileNameToStore));

            $comment->attachment = $fileNameToStore;

        }

        $comment->save();
//        $user = User::where('role', '1')->get();
//        $route = route('tickets.show', $ticket);
//        TicketCommandJob::dispatch($comment, $route, $user);
        return redirect()->back()->with('success', 'Comment successfully. Done');
    }

}
