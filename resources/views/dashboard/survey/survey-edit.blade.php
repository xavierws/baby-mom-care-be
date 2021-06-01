@extends('adminlte::page')

@section('title', 'Kuis')

@section('content_header')
<h1 class="d-inline">SURVEY</h1>
@include('components.validation')
@stop

@section('content')
<div class="card mb-0">
    <div class="card-header">Membuat Survey</div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <form action="{{ route('survey.update', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="question">
                        <div class="form-group">
                            <label for="title">Judul Survey</label>
                            <input type="text" name="title" id="" class="form-control" value="{{ $survey->title }}">
                        </div>
                        <div class="form-group">
                            <label for="choice_type">Tipe Survey</label>
                            <select name="choice_type" id="" class="form-control col-3">
                                <option value="number" {{ $survey->choice_type == 'number'? 'selected':'' }}>angka 1-5</option>
                                <option value="text" {{ $survey->choice_type == 'text'? 'selected':'' }}>text</option>
                                <option value="yes_no" {{ $survey->choice_type == 'yes_no'? 'selected':'' }}>ya/tidak</option>
                            </select>
                        </div>

                        <p class="d-none">{{ $i = 1 }}</p>
                        @foreach ($survey->questions as $q)
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="{{ 'question['.$i.']' }}">Pertanyaan {{ $i }}</label>
                                        <textarea type="text" class="form-control mb-3" name="{{ 'question['.$i.']' }}" required>{{ $q->question }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <p class="d-none">{{ $i++ }}</p>
                        @endforeach

                        <p class="d-none" id="numbQ">{{ $i }}</p>
                        <input type="hidden" name="numbQ" value="{{ $i }}">
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
    var i = parseInt(document.getElementById("numbQ").innerText);
    var total = parseInt(document.getElementById("numbQ").innerText) - 1;

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
                    Q.setAttribute("name", "question[new][" + i + "]");
                    Q.required = true;

                    // //create div row 1
                    // var row1 = document.createElement("div");
                    // row1.setAttribute("class", "row mb-3");

                    //     //create div col 1
                    //     var col1 = document.createElement("div");
                    //     col1.setAttribute("class", "col");

                    //         //create label c1
                    //         var CL1 = document.createElement("label");
                    //         CL1.setAttribute("for", "choice["+i+"]["+1+"]");
                    //         CL1.innerHTML = "Pilihan 1";

                    //         //create choice 1
                    //         var C1 = document.createElement("textarea");
                    //         C1.setAttribute("type", "text");
                    //         C1.setAttribute("class", "form-control");
                    //         C1.setAttribute("name", "choice["+i+"]["+1+"]");
                    //         C1.setAttribute("placeholder", "pilihan 1")
                    //         C1.required = true;

                    //     //create div col 2
                    //     var col2 = document.createElement("div");
                    //     col2.setAttribute("class", "col");

                    //         //create label c2
                    //         var CL2 = document.createElement("label");
                    //         CL2.setAttribute("for", "choice["+i+"]["+2+"]");
                    //         CL2.innerHTML = "Pilihan 2";

                    //         //create choice 2
                    //         var C2 = document.createElement("textarea");
                    //         C2.setAttribute("type", "text");
                    //         C2.setAttribute("class", "form-control");
                    //         C2.setAttribute("name", "choice["+i+"]["+2+"]");
                    //         C2.setAttribute("placeholder", "pilihan 1")
                    //         C2.required = true;

                    //     //create div col 3
                    //     var col3 = document.createElement("div");
                    //     col3.setAttribute("class", "col");

                    //         //create label c3
                    //         var CL3 = document.createElement("label");
                    //         CL3.setAttribute("for", "choice["+i+"]["+3+"]");
                    //         CL3.innerHTML = "Pilihan 3";

                    //         //create choice 3
                    //         var C3 = document.createElement("textarea");
                    //         C3.setAttribute("type", "text");
                    //         C3.setAttribute("class", "form-control");
                    //         C3.setAttribute("name", "choice["+i+"]["+3+"]");
                    //         C3.setAttribute("placeholder", "pilihan 1")
                    //         C3.required = true;

                    //create row 2
                    var row2 = document.createElement("div");
                    row2.setAttribute("class", "row");

                        // //create col
                        // var col4 = document.createElement("div");
                        // col4.setAttribute("class", "col-3");

                        //     //create label
                        //     var TL = document.createElement("label");
                        //     TL.setAttribute("for", "choice[true]["+i+"]");
                        //     TL.innerHTML = "Jawaban Benar";

                        //     //create true choice
                        //     var TC = document.createElement("select");
                        //     TC.setAttribute("name", "choice[true]["+i+"]");
                        //     TC.setAttribute("class", "form-control");
                        //     TC.required = true;

                        //         //create option
                        //         var opt1 = document.createElement("option");
                        //         opt1.setAttribute("value", "1");
                        //         opt1.innerHTML = "Pilihan 1"

                        //         var opt2 = document.createElement("option");
                        //         opt2.setAttribute("value", "2");
                        //         opt2.innerHTML = "Pilihan 2"

                        //         var opt3 = document.createElement("option");
                        //         opt3.setAttribute("value", "3");
                        //         opt3.innerHTML = "Pilihan 3"

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

        // form.appendChild(row1);

        // col1.appendChild(CL1);
        // col1.appendChild(C1);
        // row1.appendChild(col1);

        // col2.appendChild(CL2);
        // col2.appendChild(C2);
        // row1.appendChild(col2);

        // col3.appendChild(CL3);
        // col3.appendChild(C3);
        // row1.appendChild(col3);

        form.appendChild(row2);
        // row2.appendChild(col4);
        // col4.appendChild(TL);
        // col4.appendChild(TC);
        // TC.appendChild(opt1);
        // TC.appendChild(opt2);
        // TC.appendChild(opt3);
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
