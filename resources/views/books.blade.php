@extends('layouts.layout')

@section('search')
    <form class="form-inline my-2 my-lg-0 mr-2" action="searchbook" method="get">
        <input class="form-control mr-sm-2" type="search" name="search" >
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
    </form>
@endsection

@section('content')
    <br>
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="book_table">
        <thead>
        <tr>
            <th width="10%">Обложка</th>
            <th width="18%">Название</th>
            <th width="17%">Автор</th>
            <th width="30%">Описание</th>
            <th width="10%">Дата</th>
            <th width="11%">Действие</th>
        </tr>
        </thead>
        @csrf
        @foreach($books as $value)
            <tr class="book{{ $value->id }}">
                <td >
                    <img src="{{ asset('/storage/'.$value->image) }}" alt="cover" width="100px" height="100px">
                </td>
                <td>{{ $value->title }}</td>
                <td></td>
                <td>{{ $value->description }}</td>
                <td>{{ $value->publicated }}</td>
                <td>
                    <a href="#" class="edit-modal btn btn-warning btn-sm" data-id="{{ $value->id }}"
                       data-title="{{ $value->title }}" data-publicated="{{ $value->publicated }}" data-description=" {{$value->description}}">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <a href="#" class="delete-modal btn btn-danger btn-sm" data-id="{{ $value->id }}"
                       data-title="{{ $value->title }}" data-image="{{ $value->image }}" data-publicated="{{ $value->publicated }}" data-description=" {{$value->description}}">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </table>
</div>
<br />
<br />

<div id="create_book" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-4" for="title">Название :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="title" name="title"
                                   placeholder="Название" >
                            <br/>
                            <p class="error error1 text-center alert alert-danger" hidden></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Автор :</label>
                        <div class="col-sm-8">
                            @foreach( $authors as $author)
                                <input type="checkbox" name="author" id="author" value="{{ $author->id }}">
                                <label >{{ $author->surname }}</label>
                                <br>
                            @endforeach

                        </div>
                    </div>
                    <div class="form-group">
                            <label class="control-label col-md-4">Обложка : </label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image" />
                                <span id="store_image"></span>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Описание : </label>
                        <div class="col-md-8">
                            <textarea rows="5" type="text" name="description" id="description" class="form-control"></textarea>
                        </div>
                        <p class="error error2 text-center alert alert-danger" hidden></p>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="publicated">Дата публикации : </label>
                        <div class="col-md-8">
                            <input type="date" name="publicated" id="publicated" class="form-control"/>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" type="submit" id="add">
                    <span class="fa fa-plus"></span>Сохранить
                </button>
                <button class="btn btn-warning" type="button" data-dismiss="modal">
                    <span class="fa fa-remobe"></span>Закрыть
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="modal" enctype="multipart/form-data">
                    <div class="form-group" hidden>
                        <label class="control-label col-sm-2" for="id">ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bid" disabled>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label col-md-4" for="tit">Название :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="tit" name="tit"
                                   placeholder="Название" >
                            <br/>
                            <p class="error error1 text-center alert alert-danger" hidden></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Автор :</label>
                        <div class="col-sm-8">
                            @foreach( $authors as $author)
                                <input class="autho" type="checkbox" name="aut"  value="{{ $author->id }}">
                                <label>{{ $author->surname }}</label>
                                <br>
                            @endforeach

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Обложка : </label>
                        <div class="col-md-8">
                            <input type="file" name="im" id="im" />
                            <span id="store_image"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Описание : </label>
                        <div class="col-md-8">
                            <textarea rows="5" type="text" name="des" id="des" class="form-control"></textarea>
                        </div>
                        <p class="error error2 text-center alert alert-danger" hidden></p>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4" for="publicated">Дата публикации : </label>
                        <div class="col-md-8">
                            <input type="date" name="pub" id="pub" class="form-control"/>
                        </div>
                    </div>
                </form>

                <div class="deleteContent">
                    Уверенны что хотите удалить ?<span class="title"></span>
                    <span class="id" hidden></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn actionBtn" data-dismiss="modal">
                    <span id="footer_action_button" class="fa"></span>
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span class="fa"></span>Закрыть
                </button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
    });
    $(document).ready(function() {
        $(document).on('click', '.create-modal', function () {
            $('#create_book').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Добавить книгу');
        });

        $('#add').click(function () {
            $.ajax({
                type: "POST",
                url: "addbook",
                cache: false,
                data:
                    {
                        '_token': $('input[name=_token]').val(),
                        'title': $('#title').val(),
                        'description': $('#description').val(),
                        'publicated': $('#publicated').val(),

                    },
                success: function (data) {
                    if ((data.errors)) {
                        $('.error').removeAttr('hidden');
                        $('.error1').text(data.errors.title);
                        $('.error2').text(data.errors.description);
                    } else {
                        if (data.description == null) {
                            data.description = '';
                        }
                        $('.error').remove();
                        $('#book_table').append("<tr class='book" + data.id + "'>" +
                            "<td>" + "<img src='/storage/uploads/" + data.image  + "' >" + "</td>" +
                            "<td>" + data.title + "</td>" +
                            "<td>" + 'Автор' + "</td>" +
                            "<td>" + data.description + "</td>" +
                            "<td>" + data.publicated + "</td>" +
                            "<td><button class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-image='" + data.image + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='fa fa-pencil'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id  + "'><span class='fa fa-trash'></span></button>" + "</td>" +
                            "</tr>");
                        $('#create_book').modal('hide');
                    }
                },
            });
            $('#image').val('');
            $('#title').val('');
            $('#description').val('');
            $('#publicated').val('');
        });

        $(document).on('click', '.edit-modal', function () {
            $('#footer_action_button').text("Изменить!");
            $('#footer_action_button').addClass('fa-check');
            $('#footer_action_button').removeClass('fa-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Изменить автора');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#bid').val($(this).data('id'));
            $('#tit').val($(this).data('title'));
            // $('#im').val($(this).data('image'));
            $('#pub').val($(this).data('publicated'));
            $('#des').val($(this).data('description'));
            $('#myModal').modal('show');
        });
        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'POST',
                url: 'editauthor',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('.id').text(),
                    'title': $('#tit').val(),
                    'description': $('#des').val(),
                    'publicated': $('#pub').val(),
                },
                success: function(data) {
                    $('.book' + data.id).replaceWith("<tr class='book" + data.id + "'>"+
                        "<td>" + ФОТО + "</td>"+
                        "<td>" + data.title + "</td>"+
                        "<td>" + Автор + "</td>"+
                        "<td>" + data.description + "</td>"+
                        "<td>" + data.publicated + "</td>"+
                        "<td><button class='edit-modal btn btn-warning btn-sm' data-id='" + data.id  + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='fa fa-pencil'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id  + "'><span class='fa fa-trash'></span></button>" + "</td>" +
                        "</tr>");
                }
            });
        });

        $(document).on('click', '.delete-modal', function () {
            $('#footer_action_button').text("Удалить");
            $('#footer_action_button').removeClass('fa-check');
            $('#footer_action_button').addClass('fa-trash');
            $('.actionBtn').removeClass('btn-success');
            $('.actionBtn').addClass('btn-danger');
            $('.actionBtn').addClass('delete');
            $('.modal-title').text('Удалить автора');
            $('.id').text($(this).data('id'));
            $('.deleteContent').show();
            $('.form-horizontal').hide();
            $('#myModal').modal('show');
        });

        $('.modal-footer').on('click', '.delete', function () {
            $.ajax({
                type: 'POST',
                url: 'deletebook',
                cache: false,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('.id').text()
                },
                success: function (data) {
                    $('.book' + $('.id').text()).remove();
                }
            });
        });
    });
</script>
@endsection
