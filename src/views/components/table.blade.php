<table class="table table-hover">
    <thead>
        <tr>
            @foreach($table->columns as $column)
                <th>{{ $column->title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($table->collection as $object)
            <tr>
                @foreach($table->columns as $column)
                    <td>
                        @if($column->type === $types['TITLE'])
                            <h4>{{ $object->{$column->name} }}</h4>
                        @endif
                        @if($column->type === $types['TEXT'])
                            {{ $object->{$column->name} }}
                        @endif
                        @if($column->type === $types['ACTIONS'])
                            @php
                            $actionsTypes = $actionTypes($column->name);
                            @endphp
                            <div class="td-actions float-right row mr-2">
                                @foreach ($actionsTypes as $type)
                                    @if ($type === 'edit')
                                        <a
                                            href="{{ route($column->options->actions['edit']['route'], $object->id) }}"
                                            type="button"
                                            rel="tooltip"
                                            title="Edit"
                                            class="btn btn-primary btn-link btn-sm"
                                            data-original-title="Edit"
                                        >
                                            <i class="material-icons">edit</i>
                                        </a>
                                    @endif
                                    @if ($type === 'destroy')
                                        <form
                                            method="POST"
                                            id="destroyPost-{{$object->id}}"
                                            action="{{ route($column->options->actions['destroy']['route'], $object->id) }}"
                                        >
                                            {{ method_field('DELETE') }}
                                            @csrf
                                            <button
                                                type="submit"
                                                rel="tooltip"
                                                class="btn btn-danger btn-link btn-sm"
                                                data-original-title="Delete"
                                                onclick="
                                                    event.preventDefault();
                                                    let destroy = confirm('Really want to delete this');
                                                    if(destroy){ document.getElementById('destroyPost-{{$object->id}}').submit() }
                                                "
                                            >
                                                <i class="material-icons">delete</i>
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@if($table->collection->currentPage() !== $table->collection->lastPage() || $table->collection->lastPage() !== 1)
    <div class="row">
        <div class="col">
            {{ $table->collection->onEachSide(1)->links() }}
        </div>
    </div>
    <div class="row">
        <div class="col">
            Showing {{ $table->collection->currentPage() }} of {{ $table->collection->lastPage() }} pages and a total of {{ $table->collection->total() }} posts
        </div>
    </div>
@elseif($table->collection->total() === 0)
    <div class="contatiner py-5">
        <div class="row py-2">
            <div class="col text-center">
                <h2>No posts to list.</h2>
            </div>
        </div>
    </div>
@endif
