@extends('adminlte::page')

@section('title', 'Kuis')

@section('content_header')
    <h1 class="d-inline">KUIS</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">{{ $quiz->title }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <form action="{{ route('kuis.edit', $id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="d-none">{{ $i = 1 }}</div>
                        <div class="d-none">{{ $r=['A','B','C'] }}</div>
                        <div class="question">
                            @foreach ($questions as $q)
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="{{ 'question['.$i.']' }}">Pertanyaan {{ $i }}</label>
                                        <textarea type="text" class="form-control mb-3" name="{{ 'question['.$i.']' }}" placeholder="pertanyaan satu" required>{{ $q->question }}</textarea>
                                        <div class="row mb-3">
                                            <p class="d-none">{{ $j = 1 }}</p>
                                            <p class="d-none">{{ $trueAnswer = null }}</p>
                                            @forelse ($q->choices as $c)
                                                <div class="col">
                                                    <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $r[$j-1] }}</label>
                                                    <textarea type="text" name="{{ 'choice['.$i.']['.$j.']'}}" placeholder="pilihan 1" class="form-control" required>{{ $c->choice }}</textarea>
                                                    <p class="d-none">{{ $trueAnswer = $c->is_true==1? $j:$trueAnswer }}</p>
                                                    <p class="d-none">{{ $j++ }}</p>
                                                </div>
                                            @empty
                                                <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j }}</label>
                                                <textarea type="text" name="{{ 'choice['.$i.']['.$j.']' }}" placeholder="pilihan 1" rows="4" required></textarea>
                                                <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j+1 }}</label>
                                                <textarea type="text" name="{{ 'choice['.$i.']['.($j+1).']' }}" placeholder="pilihan 2" rows="4" required></textarea>
                                                <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j+2 }}</label>
                                                <textarea type="text" name="{{ 'choice['.$i.']['.($j+2).']' }}" placeholder="pilihan 3" rows="4" required></textarea>
                                            @endforelse


                                        </div>
                                        {{-- <input type="text" name="choice[1][1]" placeholder="pilihan 1" value="{{ array_key_exists(0, $data)? $data[0]['choice1'] : null }}">
                                        <input type="text" name="choice[1][2]" placeholder="pilihan 2" value="{{ array_key_exists(0, $data)? $data[0]['choice2'] : null }}">
                                        <input type="text" name="choice[1][3]" placeholder="pilihan 3" value="{{ array_key_exists(0, $data)? $data[0]['choice3'] : null }}"> --}}
                                        <div class="row">
                                            <div class="col-3">
                                                <label for="">Jawaban Benar</label>
                                                <select name="{{ 'choice[true]['.$i.']' }}" class="form-control" id="true_answer">
                                                    <option value="1" {{ $trueAnswer == 1? 'selected':'' }}>pilihan 1</option>
                                                    <option value="2" {{ $trueAnswer == 2? 'selected':'' }}>pilihan 2</option>
                                                    <option value="3" {{ $trueAnswer == 3? 'selected':'' }}>pilihan 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <p class="d-none">{{ $i++ }}</p>
                                        <p class="d-none">{{ $j=1 }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <p class="d-none" id="numbQ">{{ $i }}</p>
                            <input type="hidden" name="numbQ" value="{{ $i }}">
                        </div>



                        {{-- <button type="button" class="btn btn-outline-secondary" onclick="GFG_Fun()">Tambah
                            Pertanyaan</button> --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
        var i = parseInt(document.getElementById("numbQ").innerText);
        var total = parseInt(document.getElementById("numbQ").innerText) - 1;

        function GFG_Fun() {

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
                        QL.setAttribute("for", "question[new][" + i + "]");
                        QL.innerHTML = "Pertanyaan " + i;

                        //create question textarea
                        var Q = document.createElement("textarea");
                        Q.setAttribute("type", "text");
                        Q.setAttribute("class", "form-control mb-3");
                        Q.setAttribute("name", "question[new][" + i + "]");
                        Q.required = true;

                        //create div row 1
                        var row1 = document.createElement("div");
                        row1.setAttribute("class", "row mb-3");

                            //create div col 1
                            var col1 = document.createElement("div");
                            col1.setAttribute("class", "col");

                                //create label c1
                                var CL1 = document.createElement("label");
                                CL1.setAttribute("for", "choice[new]["+i+"]["+1+"]");
                                CL1.innerHTML = "Pilihan 1";

                                //create choice 1
                                var C1 = document.createElement("textarea");
                                C1.setAttribute("type", "text");
                                C1.setAttribute("class", "form-control");
                                C1.setAttribute("name", "choice[new]["+i+"]["+1+"]");
                                C1.setAttribute("placeholder", "pilihan 1")
                                C1.required = true;

                            //create div col 2
                            var col2 = document.createElement("div");
                            col2.setAttribute("class", "col");

                                //create label c2
                                var CL2 = document.createElement("label");
                                CL2.setAttribute("for", "choice[new]["+i+"]["+2+"]");
                                CL2.innerHTML = "Pilihan 2";

                                //create choice 2
                                var C2 = document.createElement("textarea");
                                C2.setAttribute("type", "text");
                                C2.setAttribute("class", "form-control");
                                C2.setAttribute("name", "choice[new]["+i+"]["+2+"]");
                                C2.setAttribute("placeholder", "pilihan 1")
                                C2.required = true;

                            //create div col 3
                            var col3 = document.createElement("div");
                            col3.setAttribute("class", "col");

                                //create label c3
                                var CL3 = document.createElement("label");
                                CL3.setAttribute("for", "choice[new]["+i+"]["+3+"]");
                                CL3.innerHTML = "Pilihan 3";

                                //create choice 3
                                var C3 = document.createElement("textarea");
                                C3.setAttribute("type", "text");
                                C3.setAttribute("class", "form-control");
                                C3.setAttribute("name", "choice[new]["+i+"]["+3+"]");
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
                                TL.setAttribute("for", "choice[new][true]["+i+"]");
                                TL.innerHTML = "Jawaban Benar";

                                //create true choice
                                var TC = document.createElement("select");
                                TC.setAttribute("name", "choice[new][true]["+i+"]");
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
                            <textarea type="text" class="form-control" name="question[2]" placeholder="pertanyaan dua">{{ array_key_exists(1, $data)? $data[1]['question'] : null }}</textarea>
                            <input type="text" name="choice[2][1]" placeholder="pilihan 1" value="{{ array_key_exists(1, $data)? $data[1]['choice1'] : null }}">
                            <input type="text" name="choice[2][2]" placeholder="pilihan 2" value="{{ array_key_exists(1, $data)? $data[1]['choice2'] : null }}">
                            <input type="text" name="choice[2][3]" placeholder="pilihan 3" value="{{ array_key_exists(1, $data)? $data[1]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][2]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 3</label>
                            <textarea type="text" class="form-control" name="question[3]" placeholder="pertanyaan tiga">{{ array_key_exists(2, $data)? $data[2]['question'] : null }}</textarea>
                            <input type="text" name="choice[3][1]" placeholder="pilihan 1" value="{{ array_key_exists(2, $data)? $data[2]['choice1'] : null }}">
                            <input type="text" name="choice[3][2]" placeholder="pilihan 2" value="{{ array_key_exists(2, $data)? $data[2]['choice2'] : null }}">
                            <input type="text" name="choice[3][3]" placeholder="pilihan 3" value="{{ array_key_exists(2, $data)? $data[2]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][3]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 4</label>
                            <textarea type="text" class="form-control" name="question[4]" placeholder="pertanyaan empat">{{ array_key_exists(3, $data)? $data[3]['question'] : null }}</textarea>
                            <input type="text" name="choice[4][1]" placeholder="pilihan 1" value="{{ array_key_exists(3, $data)? $data[3]['choice1'] : null }}">
                            <input type="text" name="choice[4][2]" placeholder="pilihan 2" value="{{ array_key_exists(3, $data)? $data[3]['choice2'] : null }}">
                            <input type="text" name="choice[4][3]" placeholder="pilihan 3" value="{{ array_key_exists(3, $data)? $data[3]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][4]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 5</label>
                            <textarea type="text" class="form-control" name="question[5]" placeholder="pertanyaan lima">{{ array_key_exists(4, $data)? $data[4]['question'] : null }}</textarea>
                            <input type="text" name="choice[5][1]" placeholder="pilihan 1" value="{{ array_key_exists(4, $data)? $data[4]['choice1'] : null }}">
                            <input type="text" name="choice[5][2]" placeholder="pilihan 2" value="{{ array_key_exists(4, $data)? $data[4]['choice2'] : null }}">
                            <input type="text" name="choice[5][3]" placeholder="pilihan 3" value="{{ array_key_exists(4, $data)? $data[4]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][5]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 6</label>
                            <textarea type="text" class="form-control" name="question[6]" placeholder="pertanyaan enam">{{ array_key_exists(5, $data)? $data[5]['question'] : null }}</textarea>
                            <input type="text" name="choice[6][1]" placeholder="pilihan 1" value="{{ array_key_exists(5, $data)? $data[5]['choice1'] : null }}">
                            <input type="text" name="choice[6][2]" placeholder="pilihan 2" value="{{ array_key_exists(5, $data)? $data[5]['choice2'] : null }}">
                            <input type="text" name="choice[6][3]" placeholder="pilihan 3" value="{{ array_key_exists(5, $data)? $data[5]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][6]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 7</label>
                            <textarea type="text" class="form-control" name="question[7]" placeholder="pertanyaan tujuh">{{ array_key_exists(6, $data)? $data[6]['question'] : null }}</textarea>
                            <input type="text" name="choice[7][1]" placeholder="pilihan 1" value="{{ array_key_exists(6, $data)? $data[6]['choice1'] : null }}">
                            <input type="text" name="choice[7][2]" placeholder="pilihan 2" value="{{ array_key_exists(6, $data)? $data[6]['choice2'] : null }}">
                            <input type="text" name="choice[7][3]" placeholder="pilihan 3" value="{{ array_key_exists(6, $data)? $data[6]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][7]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 8</label>
                            <textarea type="text" class="form-control" name="question[8]" placeholder="pertanyaan delapan">{{ array_key_exists(7, $data)? $data[7]['question'] : null }}</textarea>
                            <input type="text" name="choice[8][1]" placeholder="pilihan 1" value="{{ array_key_exists(7, $data)? $data[7]['choice1'] : null }}">
                            <input type="text" name="choice[8][2]" placeholder="pilihan 2" value="{{ array_key_exists(7, $data)? $data[7]['choice2'] : null }}">
                            <input type="text" name="choice[8][3]" placeholder="pilihan 3" value="{{ array_key_exists(7, $data)? $data[7]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][8]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 9</label>
                            <textarea type="text" class="form-control" name="question[9]" placeholder="pertanyaan sembilan">{{ array_key_exists(8, $data)? $data[8]['question'] : null }}</textarea>
                            <input type="text" name="choice[9][1]" placeholder="pilihan 1" value="{{ array_key_exists(8, $data)? $data[8]['choice1'] : null }}">
                            <input type="text" name="choice[9][2]" placeholder="pilihan 2" value="{{ array_key_exists(8, $data)? $data[8]['choice2'] : null }}">
                            <input type="text" name="choice[9][3]" placeholder="pilihan 3" value="{{ array_key_exists(8, $data)? $data[8]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][9]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Pertanyaan 10</label>
                            <textarea type="text" class="form-control" name="question[10]" placeholder="pertanyaan sepuluh">{{ array_key_exists(9, $data)? $data[9]['question'] : null }}</textarea>
                            <input type="text" name="choice[10][1]" placeholder="pilihan 1" value="{{ array_key_exists(9, $data)? $data[9]['choice1'] : null }}">
                            <input type="text" name="choice[10][2]" placeholder="pilihan 2" value="{{ array_key_exists(9, $data)? $data[9]['choice2'] : null }}">
                            <input type="text" name="choice[10][3]" placeholder="pilihan 3" value="{{ array_key_exists(9, $data)? $data[9]['choice3'] : null }}">
                            <label for="true_answer">Jawaban Benar</label>
                            <select name="choice[true][10]" id="true_answer">
                                <option value="1">pilihan 1</option>
                                <option value="2">pilihan 2</option>
                                <option value="3">pilihan 3</option>
                            </select>
                        </div> --}}



