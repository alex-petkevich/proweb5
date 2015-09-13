<?php


use Illuminate\Contracts\Auth\Guard;

class CommentsController extends BaseController
{

    /**
     * @var \jorenvanhocht\Blogify\Models\Comment
     */
    protected $comment;

    /**
     * @param \jorenvanhocht\Blogify\Models\Comment $comment
     * @param \Illuminate\Contracts\Auth\Guard $auth
     * @param \jorenvanhocht\Tracert\Tracert $tracert
     */
    public function __construct(
        Comment $comment,
        Guard $auth
    ) {
        parent::__construct($auth);

        $this->comment = $comment;
    }

    ///////////////////////////////////////////////////////////////////////////
    // View methods
    ///////////////////////////////////////////////////////////////////////////

    /**
     * @param string $revised
     * @return \Illuminate\View\View
     */
    public function index($revised = "pending")
    {
        $revised = $this->checkRevised($revised);
        if ($revised === false) {
            abort(404);
        }

        $data = [
            'comments' => $this->comment
                                ->byRevised($revised)
                                ->paginate($this->config->items_per_page),
            'revised' => $revised,
        ];

        return view('admin.comments.index', $data);
    }


    ///////////////////////////////////////////////////////////////////////////
    // CRUD methods
    ///////////////////////////////////////////////////////////////////////////

    /**
     * @param string $hash
     * @param string $new_revised
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus($hash, $new_revised)
    {
        $revised = $this->checkRevised($new_revised);
        if ($revised === false) {
            abort(404);
        }

        $comment = $this->comment->byHash($hash);
        $comment->revised = $revised;
        $comment->save();

        $message = trans(
            'blogify::notify.comment_success',
            ['action' => $new_revised]
        );
        session()->flash('notify', ['success', $message]);

        return redirect()->route('admin.comments.index');
    }

    ///////////////////////////////////////////////////////////////////////////
    // Helper methods
    ///////////////////////////////////////////////////////////////////////////

    /**
     * Check if the given revised
     * is valid
     *
     * @param string $revised
     * @return int|bool
     */
    private function checkRevised($revised)
    {
        $allowed = [1 => 'pending', 2 => 'approved', 3 => 'disapproved'];

        return array_search($revised, $allowed);
    }

}