@extends('adminlte::page')

@section('title', 'Kuis')

@section('content_header')
<h1 class="d-inline">KUIS</h1>
@include('components.validation')
@stop

@section('content')
<div class="card mb-0">
    <div class="card-header">Membuat Kuis</div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="{{ route('kuis.store', $id) }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="question[1]">Pertanyaan 1</label>
                                <textarea type="text" class="form-control mb-3" name="question[1]" required></textarea>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="choice[1][1]">Pilihan 1</label>
                                        <textarea type="text" class="form-control" name="choice[1][1]"
                                            placeholder="pilihan 1" required></textarea>
                                    </div>
                                    <div class="col">
                                        <label for="hoice[1][2]">Pilihan 2</label>
                                        <textarea type="text" class="form-control" name="choice[1][2]"
                                            placeholder="pilihan 2" required></textarea>
                                    </div>
                                    <div class="col">
                                        <label for="choice[1][3]">Pilihan 3</label>
                                        <textarea type="text" class="form-control" name="choice[1][3]"
                                            placeholder="pilihan 3" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <label for="choice[true][1]">Jawaban Benar</label>
                                        <select name="choice[true][1]" class="form-control" id="true_answer" required>
                                            <option value="1">pilihan 1</option>
                                            <option value="2">pilihan 2</option>
                                            <option value="3">pilihan 3</option>
                                        </select>
                                    </div>
                                    <div class="col align-self-end text-right">
                                        <button type="button" class="btn btn-danger"
                                            onclick="removeForm(this)">hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-secondary" onclick="GFG_Fun()">Tambah
                        Pertanyaan</button>
                    <br>
                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>

        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    // var down = document.getElementById("GFG_DOWN");

    // Create a break line element
    var br = document.createElement("br");
    var i = 2;
    var total = 0;

    function GFG_Fun() {

        // // Create a form synamically
        // var form = document.createElement("form");
        // form.setAttribute("method", "post");
        // form.setAttribute("action", "submit.php");

        //create div card

        //create div card-body

        //create div form-group
        var form = document.createElement("div");
        form.setAttribute("class", "form-group");

        //create question label
        var label = document.createElement("label");
        label.setAttribute("for", "question[" + i + "]");
        label.innerHTML("Pertanyaan " + i);

        //create question textarea
        var Q = document.createElement("textarea");
        Q.setAttribute("type", "text");
        Q.setAttribute("class", "form-control")
        Q.setAttribute("name", "question[" + i + "]")
        // Q.setAttribute("placeholder", )

        // // Create an input element for Full Name
        // var FN = document.createElement("input");
        // FN.setAttribute("type", "text");
        // FN.setAttribute("name", "FullName");
        // FN.setAttribute("placeholder", "Full Name");

        //  // Create an input element for date of birth
        // var DOB = document.createElement("input");
        // DOB.setAttribute("type", "text");
        // DOB.setAttribute("name", "dob");
        // DOB.setAttribute("placeholder", "DOB");

        //  // Create an input element for emailID
        // var EID = document.createElement("input");
        // EID.setAttribute("type", "text");
        // EID.setAttribute("name", "emailID");
        // EID.setAttribute("placeholder", "E-Mail ID");

        //   // Create an input element for password
        // var PWD = document.createElement("input");
        // PWD.setAttribute("type", "password");
        // PWD.setAttribute("name", "password");
        // PWD.setAttribute("placeholder", "Password");

        //    // Create an input element for retype-password
        // var RPWD = document.createElement("input");
        // RPWD.setAttribute("type", "password");
        // RPWD.setAttribute("name", "reTypePassword");
        // RPWD.setAttribute("placeholder", "ReEnter Password");

        // // create a submit button
        // var s = document.createElement("input");
        // s.setAttribute("type", "submit");
        // s.setAttribute("value", "Submit");

        // // Append the full name input to the form
        // form.appendChild(FN);

        // // Inserting a line break
        // form.appendChild(br.cloneNode());

        // // Append the DOB to the form
        // form.appendChild(DOB);
        // form.appendChild(br.cloneNode());

        // // Append the emailID to the form
        // form.appendChild(EID);
        // form.appendChild(br.cloneNode());

        // // Append the Password to the form
        // form.appendChild(PWD);
        // form.appendChild(br.cloneNode());

        // // Append the ReEnterPassword to the form
        // form.appendChild(RPWD);
        // form.appendChild(br.cloneNode());

        // // Append the submit button to the form
        // form.appendChild(s);

        document.getElementsByClassName("form-group")[0]
            .appendChild(form);
    }

    function removeForm(selectedField) {
        selectedField.closest('.card').remove();
    }

</script>
@stop




{{-- <div class="form-group">
                            <label for="">Pertanyaan 2</label>
                            <textarea type="text" class="form-control" name="question[2]" placeholder="pertanyaan dua"></textarea>
                            <input type="text" name="choice[2][1]" placeholder="pilihan 1">
                            <input type="text" name="choice[2][2]" placeholder="pilihan 2">
                            <input type="text" name="choice[2][3]" placeholder="pilihan 3">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][2]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 3</label>
                            <textarea type="text" class="form-control" name="question[3]" placeholder="pertanyaan tiga"></textarea>
                            <input type="text" name="choice[3][1]" placeholder="pilihan 1">
                            <input type="text" name="choice[3][2]" placeholder="pilihan 2">
                            <input type="text" name="choice[3][3]" placeholder="pilihan 3">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][3]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 4</label>
                            <textarea type="text" class="form-control" name="question[4]" placeholder="pertanyaan empat"></textarea>
                            <input type="text" name="choice[4][1]" placeholder="pilihan 1">
                            <input type="text" name="choice[4][2]" placeholder="pilihan 2">
                            <input type="text" name="choice[4][3]" placeholder="pilihan 3">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][4]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 5</label>
                            <textarea type="text" class="form-control" name="question[5]" placeholder="pertanyaan lima"></textarea>
                            <input type="text" name="choice[5][1]" placeholder="pilihan 5">
                            <input type="text" name="choice[5][2]" placeholder="pilihan 5">
                            <input type="text" name="choice[5][3]" placeholder="pilihan 5">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][5]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 6</label>
                            <textarea type="text" class="form-control" name="question[6]" placeholder="pertanyaan enam"></textarea>
                            <input type="text" name="choice[6][1]" placeholder="pilihan 6">
                            <input type="text" name="choice[6][2]" placeholder="pilihan 6">
                            <input type="text" name="choice[6][3]" placeholder="pilihan 6">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][6]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 7</label>
                            <textarea type="text" class="form-control" name="question[7]" placeholder="pertanyaan tujuh"></textarea>
                            <input type="text" name="choice[7][1]" placeholder="pilihan 7">
                            <input type="text" name="choice[7][2]" placeholder="pilihan 7">
                            <input type="text" name="choice[7][3]" placeholder="pilihan 7">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][7]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 8</label>
                            <textarea type="text" class="form-control" name="question[8]" placeholder="pertanyaan delapan"></textarea>
                            <input type="text" name="choice[8][1]" placeholder="pilihan 8">
                            <input type="text" name="choice[8][2]" placeholder="pilihan 8">
                            <input type="text" name="choice[8][3]" placeholder="pilihan 8">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][8]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 9</label>
                            <textarea type="text" class="form-control" name="question[9]" placeholder="pertanyaan sembilan"></textarea>
                            <input type="text" name="choice[9][1]" placeholder="pilihan 9">
                            <input type="text" name="choice[9][2]" placeholder="pilihan 9">
                            <input type="text" name="choice[9][3]" placeholder="pilihan 9">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][9]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 10</label>
                            <textarea type="text" class="form-control" name="question[10]" placeholder="pertanyaan sepuluh"></textarea>
                            <input type="text" name="choice[10][1]" placeholder="pilihan 10">
                            <input type="text" name="choice[10][2]" placeholder="pilihan 10">
                            <input type="text" name="choice[10][3]" placeholder="pilihan 10">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][10]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div> --}}
