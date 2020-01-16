@extends('layouts.layout')

@section('search')
<form class="form-inline my-2 my-lg-0 mr-2" action="searchauthor" method="get">
    <input class="form-control mr-sm-2" type="search" name="search" >
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Поиск</button>
</form>
@endsection

@section('content')
    <br />
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="author_table">
            <thead>
            <tr>
                <th width="30%">
                    Фамилия </th>
                <th width="30%">Имя</th>
                <th width="30%">Отчество</th>
                <th width="10%">Действие</th>
            </tr>
            </thead>
            <tbody>
                @csrf
                @foreach($authors as $value)
                    <tr class="author{{$value->id }}">
                        <td>{{ $value->surname }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->patronymic }}</td>
                        <td>
                            <a href="#" class="edit-modal btn btn-warning btn-sm" data-id="{{ $value->id }}"
                               data-surname="{{ $value->surname }}" data-name=" {{$value->name}}"
                               data-patronymic="{{ $value->patronymic }}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="#" class="delete-modal btn btn-danger btn-sm" data-id="{{ $value->id }}"
                               data-surname="{{ $value->surname }}" data-name=" {{$value->name}}"
                               data-patronymic="{{ $value->patronymic }}">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
        {{ $authors->links() }}
    </div>
    <br /><br />

    <div id="create" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        @csrf
                        <div class="form-group">
                            <label class="control-label col-md-4" for="surname">Фамилия :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="surname" name="surname"
                                       placeholder="Фамилия" required>
                                <br/>
                                <p class="error error1 text-center alert alert-danger" hidden></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="name">Имя :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Имя" required>
                                <br/>
                                <p class="error error2 text-center alert alert-danger" hidden></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4" for="patronymic">Отчество :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Отчество">
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
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="modal">
                        <div class="form-group" hidden>
                            <label class="control-label col-sm-2" for="id">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fid" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="surname">Фамилия</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="s">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Имя</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="n">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="patronymic">Отчество</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="p">
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
        $(document).on('click','.create-modal', function () {
            $('#create').modal('show');
            $('.form-horizontal').show();
            $('.modal-title').text('Добавить автора');
        });

        $('#add').click(function () {
                $.ajax({
                    type: "POST",
                    url: "addauthor",
                    cache: false,
                    data:
                        {
                            '_token': $('input[name=_token]').val(),
                            'surname': $('#surname').val(),
                            'name': $('#name').val(),
                            'patronymic': $('#patronymic').val(),
                        },
                    success: function (data) {
                        if ((data.errors)) {
                            $('.error').removeAttr('hidden');
                            $('.error1').text(data.errors.surname);
                            $('.error2').text(data.errors.name);
                        } else {
                            $('.error').remove();
                            if (data.patronymic == null) {
                                data.patronymic = '';
                            }
                            $('#author_table').append("<tr class='author" + data.id + "'>" +
                                "<td>" + data.surname + "</td>" +
                                "<td>" + data.name + "</td>" +
                                "<td>" + data.patronymic + "</td>" +
                                "<td><button class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-surname='" + data.surname + "' data-name='" + data.name + "' data-patronymic='" + data.patronymic + "'><span class='fa fa-pencil'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-surname='" + data.surname + "' data-name='" + data.name + "' data-patronymic='" + data.patronymic + "'><span class='fa fa-trash'></span></button>" + "</td>" +
                                "</tr>");
                            $('#create').modal('hide');
                        }
                    },
                });
                $('#surname').val('');
                $('#name').val('');
                $('#patronymic').val('');
            });


        $(document).on('click', '.edit-modal', function() {
            $('#footer_action_button').text("Изменить!");
            $('#footer_action_button').addClass('fa-check');
            $('#footer_action_button').removeClass('fa-trash');
            $('.actionBtn').addClass('btn-success');
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').addClass('edit');
            $('.modal-title').text('Изменить автора');
            $('.deleteContent').hide();
            $('.form-horizontal').show();
            $('#fid').val($(this).data('id'));
            $('#s').val($(this).data('surname'));
            $('#n').val($(this).data('name'));
            $('#p').val($(this).data('patronymic'));
            $('#myModal').modal('show');
        });

        $('.modal-footer').on('click', '.edit', function() {
            $.ajax({
                type: 'POST',
                url: 'editauthor',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $("#fid").val(),
                    'surname': $('#s').val(),
                    'name': $('#n').val(),
                    'patronymic': $('#p').val()
                },
                success: function(data) {
                    if (data.patronymic == null) {
                        data.patronymic = '';
                    }
                    $('.author' + data.id).replaceWith(" "+
                        "<tr class='post" + data.id + "'>"+
                        "<td>" + data.surname + "</td>"+
                        "<td>" + data.name + "</td>"+
                        "<td>" + data.patronymic + "</td>"+
                        "<td><button class='edit-modal btn btn-warning btn-sm' data-id='" + data.id + "' data-surname='" + data.surname + "' data-name='" + data.name + "' data-patronymic='" + data.patronymic + "'><span class='fa fa-pencil'></span></button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-surname='" + data.surname + "' data-name='" + data.name + "' data-patronymic='" + data.patronymic + "'><span class='fa fa-trash'></span></button>" + "</td>" + "</tr>");
                }
            });
        });

        $(document).on('click', '.delete-modal', function() {
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
            $('.title').html($(this).data('title'));
            $('#myModal').modal('show');
        });

        $('.modal-footer').on('click', '.delete', function(){
            $.ajax({
                type: 'POST',
                url: 'deleteauthor',
                cache: false,
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': $('.id').text()
                },
                success: function(data){
                    $('.author' + $('.id').text()).remove();
                }
            });
        });

    </script>
@endsection
