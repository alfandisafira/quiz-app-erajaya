$(function(){
    function randomArrayNumber(n) {
        let arr = [];
        while (arr.length < n) {
            let rand_number = Math.floor(Math.random() * n)
            if (!arr.includes(rand_number)) {
                arr.push(rand_number);
            }
        }

        return arr;
    }

    function millisecondsToTime(milli){
        var seconds = Math.floor((milli / 1000) % 60);
        var minutes = Math.floor((milli / (60 * 1000)) % 60);

        return minutes + ":" + seconds ;
    }

    let currentTime = parseInt($('#workingTime').html());
    // let currentTime = 5000;
    
    setInterval(displayTime, 1000);
    
    $('#workingTime').html(millisecondsToTime(currentTime));

    function displayTime() {
        if (currentTime == 1000) {
            $('#quizForm').submit();
        }
        currentTime = currentTime - 1000;
        $('#workingTime').html(millisecondsToTime(currentTime));
    }

    // jQuery methods go here...
    $('.nav-link').on('click', function(){
        $('.nav-link.active').removeClass('active');
        $('.tab-pane.active').removeClass('active');
        
        let id_name = $(this).attr('href');
        $(this).addClass('active');

        $(id_name).addClass('active');
    });

    $('.add-question').on('click', function(){
        let length_q = parseInt($( ".question" ).length);

        let last_q = $( ".question" ).last();

        let color = 'bg-light'
        if (length_q % 2 == 0) {
            color = 'bg-dark text-white';
        }

        length_q++;

        if (length_q > 10){
            $(".delete-question").removeClass("d-none");
        }

        let options_element = "";
        for (let j = 1; j <= 4; j++) {
            options_element += 
            `<div class="form-group col-3">
                <label for="question[${length_q}][options][${j}]">Opt. ${j}</label>
                <input type="text" class="form-control" name="question[${length_q}][options][${j}]" required>
            </div>
            `
        }

        let question_element = 
        `<div class="${color} p-1 mb-3 question">
            <div class="form-group">
                <input type="text" class="form-control" name="question[${length_q}][sentence]" placeholder="Question ${length_q}" required>
            </div>
            <div class="form-row">
                ${options_element}
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="answerOptions${length_q}">Right Answer</label>
                </div>
                <select class="custom-select" name="question[${length_q}][right_answer]" id="answerOptions${length_q}" required>
                    <option value="">Choose option...</option>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                    <option value="4">Option 4</option>
                </select>
            </div>
        </div>
        `

        last_q.after(question_element);
    });

    $('.delete-question').on('click', function(){
        let length_q = parseInt($( ".question" ).length);

        $( ".question" ).last().remove();

        length_q--;

        if (length_q == 10){
            $(".delete-question").addClass("d-none");
        }
    });

    $('.btn-exe').on('click', function(){
        let exercise = $(this).data('content');

        let queue_question = randomArrayNumber(exercise.questions.length);

        let new_question = [];
        for (let index = 0; index < queue_question.length; index++) {
            new_question.push(exercise.questions[queue_question[index]]);
        }
        
        exercise.questions = new_question;
        
        $('#newExercise').val(JSON.stringify(exercise));
        $('#formNewExercise').submit();
    })

    let sum_q = $('.question').length;
    let current_q = 1;
    let current_e_q = $(`.question:nth-child(${current_q})`);
    current_e_q.removeClass('d-none');
    current_e_q.find('.btn-prev').addClass('d-none');

    $('.btn-next').on('click', function(){
        if (current_q + 1 == sum_q) {
            current_e_q = $(`.question:nth-child(${current_q+1})`);
            current_e_q.find('.btn-next').addClass('d-none');
        }

        $(`.question:nth-child(${current_q})`).addClass('d-none');
        
        current_q++;
        $(`.question:nth-child(${current_q})`).removeClass('d-none');
    });

    $('.btn-prev').on('click', function(){
        $(`.question:nth-child(${current_q})`).addClass('d-none');

        current_q--;
        $(`.question:nth-child(${current_q})`).removeClass('d-none');
    });
});