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
                    <div class="question">
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
                                            <label for="choice[1][2]">Pilihan 2</label>
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
                                        {{-- <div class="col align-self-end text-right">
                                            <button type="button" class="btn btn-danger"
                                                onclick="removeForm(this)">hapus</button>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <input type="number" class="d-none" name="total" value=""> --}}
                    <button type="button" class="btn btn-outline-secondary mt-2 mr-3" onclick="GFG_Fun()">Tambah
                        Pertanyaan</button>
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
    var total = 1;

    function GFG_Fun() {

        // // Create a form synamically
        // var form = document.createElement("form");
        // form.setAttribute("method", "post");
        // form.setAttribute("action", "submit.php");

        //create div card
        var card = document.createElement("div");
        card.setAttribute("class", "card");

            //create div card-body
            var CB = document.createElement("div");
            CB.setAttribute("class", "card-body")

                //create div form-group
                var form = document.createElement("div");
                form.setAttribute("class", "form-group");

                    //create question label
                    var QL = document.createElement("label");
                    QL.setAttribute("for", "question[" + i + "]");
                    QL.innerHTML = "Pertanyaan " + i;

                    //create question textarea
                    var Q = document.createElement("textarea");
                    Q.setAttribute("type", "text");
                    Q.setAttribute("class", "form-control mb-3");
                    Q.setAttribute("name", "question[" + i + "]");
                    Q.required = true;

                    //create div row 1
                    var row1 = document.createElement("div");
                    row1.setAttribute("class", "row mb-3");

                        //create div col 1
                        var col1 = document.createElement("div");
                        col1.setAttribute("class", "col");

                            //create label c1
                            var CL1 = document.createElement("label");
                            CL1.setAttribute("for", "choice["+i+"]["+1+"]");
                            CL1.innerHTML = "Pilihan 1";

                            //create choice 1
                            var C1 = document.createElement("textarea");
                            C1.setAttribute("type", "text");
                            C1.setAttribute("class", "form-control");
                            C1.setAttribute("name", "choice["+i+"]["+1+"]");
                            C1.setAttribute("placeholder", "pilihan 1")
                            C1.required = true;

                        //create div col 2
                        var col2 = document.createElement("div");
                        col2.setAttribute("class", "col");

                            //create label c2
                            var CL2 = document.createElement("label");
                            CL2.setAttribute("for", "choice["+i+"]["+2+"]");
                            CL2.innerHTML = "Pilihan 2";

                            //create choice 2
                            var C2 = document.createElement("textarea");
                            C2.setAttribute("type", "text");
                            C2.setAttribute("class", "form-control");
                            C2.setAttribute("name", "choice["+i+"]["+2+"]");
                            C2.setAttribute("placeholder", "pilihan 1")
                            C2.required = true;

                        //create div col 3
                        var col3 = document.createElement("div");
                        col3.setAttribute("class", "col");

                            //create label c3
                            var CL3 = document.createElement("label");
                            CL3.setAttribute("for", "choice["+i+"]["+3+"]");
                            CL3.innerHTML = "Pilihan 3";

                            //create choice 3
                            var C3 = document.createElement("textarea");
                            C3.setAttribute("type", "text");
                            C3.setAttribute("class", "form-control");
                            C3.setAttribute("name", "choice["+i+"]["+3+"]");
                            C3.setAttribute("placeholder", "pilihan 1")
                            C3.required = true;

                    //create row 2
                    var row2 = document.createElement("div");
                    row2.setAttribute("class", "row");

                        //create col
                        var col4 = document.createElement("div");
                        col4.setAttribute("class", "col-3");

                            //create label
                            var TL = document.createElement("label");
                            TL.setAttribute("for", "choice[true]["+i+"]");
                            TL.innerHTML = "Jawaban Benar";

                            //create true choice
                            var TC = document.createElement("select");
                            TC.setAttribute("name", "choice[true]["+i+"]");
                            TC.setAttribute("class", "form-control");
                            TC.required = true;

                                //create option
                                var opt1 = document.createElement("option");
                                opt1.setAttribute("value", "1");
                                opt1.innerHTML = "Pilihan 1"

                                var opt2 = document.createElement("option");
                                opt2.setAttribute("value", "2");
                                opt2.innerHTML = "Pilihan 2"

                                var opt3 = document.createElement("option");
                                opt3.setAttribute("value", "3");
                                opt3.innerHTML = "Pilihan 3"

                        //create col
                        var col5 = document.createElement("div");
                        col5.setAttribute("class", "col align-self-end text-right");

                            //create button
                            var btn = document.createElement("button");
                            btn.setAttribute("type", "button");
                            btn.setAttribute("class", "btn btn-danger");
                            btn.setAttribute("onclick", "removeForm(this)");
                            btn.setAttribute("id", "btn_" + i);
                            btn.innerHTML = "Hapus"

        //append all
        card.appendChild(CB);
        CB.appendChild(form);
        form.appendChild(QL);
        form.appendChild(Q);

        form.appendChild(row1);

        col1.appendChild(CL1);
        col1.appendChild(C1);
        row1.appendChild(col1);

        col2.appendChild(CL2);
        col2.appendChild(C2);
        row1.appendChild(col2);

        col3.appendChild(CL3);
        col3.appendChild(C3);
        row1.appendChild(col3);

        form.appendChild(row2);
        row2.appendChild(col4);
        col4.appendChild(TL);
        col4.appendChild(TC);
        TC.appendChild(opt1);
        TC.appendChild(opt2);
        TC.appendChild(opt3);
        row2.appendChild(col5);
        col5.appendChild(btn);

        document.getElementsByClassName("question")[0]
            .appendChild(card);

        total++;
        i++;

        // document.getElementsByClassName("total").value = total;

        let j = i-2;
        let rBTN = document.getElementById("btn_"+j);
        rBTN.setAttribute("class", "btn btn-danger d-none");
    }

    function removeForm(selectedField) {
        selectedField.closest('.card').remove();
        i = i-1;
        total= total-1;

        let k = i-1;
        let rBTN = document.getElementById("btn_"+ k);
        rBTN.setAttribute("class", "btn btn-danger");
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
                        </div>

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
                        --}}


