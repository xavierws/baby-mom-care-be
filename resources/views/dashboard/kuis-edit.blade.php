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

                        <p class="d-none">{{ $i = 1 }}</p>

                        @foreach ($questions as $q)
                        <div class="form-group">
                            <label for="">Pertanyaan {{ $i }}</label>
                            <textarea type="text" class="form-control" name="{{ 'question['.$i.']' }}" placeholder="pertanyaan satu" required>{{ $q->question }}</textarea>
                            <div class="row">
                                <div class="col">
                                    <p class="d-none">{{ $j = 1 }}</p>
                                    @forelse ($q->choices as $c)
                                        <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j }}</label>
                                        <textarea type="text" name="{{ 'choice['.$i.']['.$j.']'}}" placeholder="pilihan 1" rows="4" required>{{ $c->choice }}</textarea>
                                        <p class="d-none">{{ $trueAnswer = $c->is_true==1? $j:$trueAnswer }}</p>
                                        <p class="d-none">{{ $j++ }}</p>
                                    @empty
                                        <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j }}</label>
                                        <textarea type="text" name="{{ 'choice['.$i.']['.$j.']' }}" placeholder="pilihan 1" rows="4" required></textarea>
                                        <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j+1 }}</label>
                                        <textarea type="text" name="{{ 'choice['.$i.']['.($j+1).']' }}" placeholder="pilihan 2" rows="4" required></textarea>
                                        <label for="{{ 'choice['.$i.']['.$j.']'}}">pilihan {{ $j+2 }}</label>
                                        <textarea type="text" name="{{ 'choice['.$i.']['.($j+2).']' }}" placeholder="pilihan 3" rows="4" required></textarea>
                                    @endforelse
                                </div>
                            </div>
                            {{-- <input type="text" name="choice[1][1]" placeholder="pilihan 1" value="{{ array_key_exists(0, $data)? $data[0]['choice1'] : null }}">
                            <input type="text" name="choice[1][2]" placeholder="pilihan 2" value="{{ array_key_exists(0, $data)? $data[0]['choice2'] : null }}">
                            <input type="text" name="choice[1][3]" placeholder="pilihan 3" value="{{ array_key_exists(0, $data)? $data[0]['choice3'] : null }}"> --}}
                            <br>
                            <label for="">Jawaban Benar</label>
                            <select name="{{ 'choice[true]['.$i.']' }}" id="true_answer">
                                <option value="1" {{ $trueAnswer == 1? 'selected':'' }}>pilihan 1</option>
                                <option value="2" {{ $trueAnswer == 2? 'selected':'' }}>pilihan 2</option>
                                <option value="3" {{ $trueAnswer == 3? 'selected':'' }}>pilihan 3</option>
                            </select>
                        </div>

                        <p class="d-none">{{ $i++ }}</p>
                        <p class="d-none">{{ $j=1 }}</p>
                        @endforeach


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

    </script>
@stop




