<table class="table table-responsive" id="posts-table">
    <thead>
        <th>Name</th>
        <th>Content</th>
        <th>User Id</th>
        <th>Image</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($posts as $posts)
        <tr>
            <td>{!! $posts->name !!}</td>
            <td>{!! $posts->content !!}</td>
            <td>{!! $posts->user_id !!}</td>
            <td>{!! $posts->image !!}</td>
            <td>
                {!! Form::open(['route' => ['posts.destroy', $posts->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('posts.show', [$posts->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('posts.edit', [$posts->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>