<?php
?>

<div class="session-data" style="display:none;">
    <?
        if(isset($_SESSION['cloud'])){
            $res = explode("\n",$_SESSION['cloud']);
            if(is_array($res)){
                foreach($res as $item){
                    if(!trim($item)) continue;
                    echo "<p>$item</p>";
                }
            }else echo "<p>$res</p>";
        }
        unset($_SESSION['cloud']);
    ?>
</div>



<div>
    <br>
    <div class='result'></div>




    <form class="default" id='form' action='' method='post'>
<!--        <legend>Добавить карточку</legend>-->

        <!--    wrapper for dictionary words found in the text-->
        <div class='dictionary-wrap'></div>

        <textarea class="form-control" name="front" id="area_front" cols="10" rows="3" style='margin-bottom:5px;
' required></textarea>
        <div class="btn-panel">
            <div type="button" class="down btn btn-outline-primary hide-on-small-phone">
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                     class='bi bi-arrow-bar-down' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd'
                          d='M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6z'/>
                </svg>
            </div>
            <div type='button' class="top btn btn-outline-primary hide-on-small-phone">
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                     class='bi bi-arrow-bar-up' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd'
                          d='M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5zm-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z'/>
                </svg>
            </div>
            <!--div разделить фразу на две-->
            <div type='button' class='div btn btn-outline-primary'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                     class='bi bi-align-center' viewBox='0 0 16 16'>
                    <path d='M8 1a.5.5 0 0 1 .5.5V6h-1V1.5A.5.5 0 0 1 8 1zm0 14a.5.5 0 0 1-.5-.5V10h1v4.5a.5.5 0 0 1-.5.5zM2 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7z'/>
                </svg>
            </div>
            <div type='button' class='clear-all btn btn-outline-primary'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                     class='bi bi-radioactive' viewBox='0 0 16 16'>
                    <path d='M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1ZM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Z'/>
                    <path d='M9.653 5.496A2.986 2.986 0 0 0 8 5c-.61 0-1.179.183-1.653.496L4.694 2.992A5.972 5.972 0 0 1 8 2c1.222 0 2.358.365 3.306.992L9.653 5.496Zm1.342 2.324a2.986 2.986 0 0 1-.884 2.312 3.01 3.01 0 0 1-.769.552l1.342 2.683c.57-.286 1.09-.66 1.538-1.103a5.986 5.986 0 0 0 1.767-4.624l-2.994.18Zm-5.679 5.548 1.342-2.684A3 3 0 0 1 5.005 7.82l-2.994-.18a6 6 0 0 0 3.306 5.728ZM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z'/>
                </svg>
            </div>
            <div type='button' class="back btn btn-outline-primary">
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                     class='bi bi-skip-backward-circle' viewBox='0 0 16 16'>
                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                    <path d='M11.729 5.055a.5.5 0 0 0-.52.038L8.5 7.028V5.5a.5.5 0 0 0-.79-.407L5 7.028V5.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0V8.972l2.71 1.935a.5.5 0 0 0 .79-.407V8.972l2.71 1.935A.5.5 0 0 0 12 10.5v-5a.5.5 0 0 0-.271-.445z'/>
                </svg>
            </div>
            <div type='button' class='reverse btn btn-outline-primary'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                     class='bi bi-arrow-repeat' viewBox='0 0 16 16'>
                    <path d='M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z'/>
                    <path fill-rule='evenodd'
                          d='M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z'/>
                </svg>
            </div>
                <div type='button' class='btn btn-outline-primary submit-button'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-save2' viewBox='0 0 16 16'>
                        <path d='M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z'></path>
                    </svg>
                </div>


        </div>

        <textarea class='form-control' name='back' id='area_back' cols='10' rows='3' style="margin-top:5px;"></textarea>
        <input type="hidden" name="queue" value="0">
        <? include(APP.'/views/cards/include/bottom_menu.php');?>
    </form>
</div>

<script src='/public/assets/js/ajax.js'></script>

<script>


    // capture the data
    function getData(){
        let sess_text_front = $('.session-data > p').eq(0).html();
        let sess_text_end = $('.session-data > p').eq(1).html();
        $('#area_front').val($.trim(sess_text_front));
        $('#area_back').val($.trim(sess_text_end));
    }

    // splits a phrase in two by line break (first line, second line)
    function divisionStr(str){
        let res = str.split(/\n/);// || [];
        // drop empty array entries (in case there were several line breaks)
        res = res.filter(element => element !== "");
        return res;
    }

    $(document).ready(function(){
        $('.submit-button').on('click', function(){
            $('#form').trigger('submit');
        })

        // fills in data carried over from the cloud
        getData();
        // swap front/back
        $('.reverse').click(function(){
            let front = $('#area_front').val();
            let back = $('#area_back').val();
            $('#area_front').val($.trim(back));
            $('#area_back').val($.trim(front));

        });

        // re-capture the data
        $('.back').click(function(){
            getData();
        });

        // move to the bottom field
        $('.down').click(function(){
            $('#area_back').val($('#area_front').val()+$('#area_back').val());
            $('#area_front').val("");
        });
        // move to the top field
        $('.top').click(function () {
            $('#area_front').val($('#area_back').val() + $('#area_front').val());
            $('#area_back').val('');
        });
        // clear the fields
        $('.clear-all').click(function(){
            $('#area_front').val('');
            $('#area_back').val('');
        });
        // split the phrase in two (first part on top, second on the bottom)
        $('.div').click(function(){
            let front = $('#area_front').val();
            let back = $('#area_back').val();
            // if the data is in the top field
            if(front){
                let arr = divisionStr($.trim(front));
                $('#area_front').val(arr[0]);
                $('#area_back').val(arr[1]);
            }
            else if(back){
                let arr = divisionStr($.trim(back));
                $('#area_front').val(arr[0]);
                $('#area_back').val(arr[1]);
            } else return false;
        });

        setTimeout(function(){
            let front = $('#area_front').val();
            let back = $('#area_back').val();
            $('#area_front').val(trimExt(front));
            $('#area_back').val(trimExt(back));

        }, 2000);

        // check whether the text contains a word already in the dictionary
        setInterval(function(){
            let front = $('#area_front').val();
            let back = $('#area_back').val();
            let text = front + back;
            finedWords(text);
        }, 2000);

        // fires on content change
        // not quite right - won't catch a word being added to the dictionary
        // $('#form').on('input','textarea', function(){
        //     let text = $(this).val();
        //     finedWords(text);
        // });


    });

    // strip stray characters from the string
    function trimExt(str){
        str = str.replace('"', ''); // strip quotes
        //str = str.replace('-', ''); // strip a hyphen
        str = str.replace(';', ''); // strip a stray character
        str = str.replace('."', ''); // strip a stray character
        //str = str.replace("'", ''); // strip a stray character
        str = str.replace(".'", ''); // strip a stray character
        str = str.replace('?"', '?'); // strip a stray character
        str = str.replace('!"', '!'); // strip a stray character
        return str;
    }

    // look up words in the dictionary
    function finedWords($text){

        $.ajax({
            url: "/cards/check", // request target
            type: "post", // HTTP method
            data: {data:$text}, // data to send
            cache: false, // skip the cache
            success: function(res){ // handle the response
                let result = uniq(res.split(' ')); // to an array, drop duplicate words
                result = result + ''; // cast to string
                result = result.replace(/[,.]/g, ' '); // replace commas/periods with a space
                if(result.length){
                    $('.dictionary-wrap').html("<div class='w-message'><div " + "class='w-label'>уже" + " в " + 'словаре</div>' + result + '</div>');
                }else{
                    $('.dictionary-wrap').empty();
                }


            },
            error: function(){ // handle the error
                alert('error');
            }
        });
    }

    function uniq(arr) {
        return Array.from(new Set(arr));
    }
</script>
