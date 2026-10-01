<?php

$url = \fw\libs\Helper::getCleanUrl($_SERVER['REQUEST_URI']);
?>

<div class='row'> <!--menu-->
    <div class='header'>
        <nav class='navbar fixed-bottom navbar-light bg-light'>
            <div class='container'>
                <div> <!--HOME-->
                    <a class='btn btn-outline-primary' href='<?if($url == "/mistakes")
                        :?>/<?else:?>/mistakes/<?endif;?>'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-house' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd'
                                  d='M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z'></path>
                            <path fill-rule='evenodd'
                                  d='M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z'></path>
                        </svg>
                    </a>
                </div>


                <div><!--ADD ITEM-->
                    <a id='add-mistake' type='button' class='btn btn-outline-success' data-bs-toggle='modal'
                       data-bs-target='#add-mistake'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-plus' viewBox='0 0 16 16'>
                            <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'></path>
                        </svg>
                    </a>
                </div>

                <?if($url == "/mistakes/detail"):?>
                    <div><!--UPDATE ITEM-->
                        <a id="edit-mistake" class='btn btn-outline-dark btn-edit-trigger' data-bs-toggle='modal'
                           data-bs-target='#edit-mistake'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                                 class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'></path>
                            </svg>
                        </a>
                    </div>
                <?endif;?>


            </div> <!--container-->

        </nav>
    </div>
</div>

<style>
    .navbar.fixed-bottom > .container{
        justify-content: end;
    }
    .navbar.fixed-bottom > .container > div{
        margin-left: 10px;
    }
</style>