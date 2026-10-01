<!--Add word to dictionary-->
<div class='modal fade' id='toDictionary' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='toDictionaryLabel' aria-hidden='true'>
    <div class='modal-dialog''>
        <div class='modal-content'>
<!--            <div class='modal-header'>-->
<!--                <h5 class='modal-title' id='toDictionaryLabel'>Словарь</h5>-->
<!--                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>-->
<!--            </div>-->
            <div class="result"></div>

            <form class='default' action='/dictionary/add' method='post'>
                <div class='modal-body'>

                    <input class='form-control' type='text' name='word' id='word' placeholder='слово' required>
                    <input class='form-control' type='text' name='pronounce' id='pronounce' placeholder='произношение'>
                    <input class='form-control' type='text' name='meaning' id='pronounce' placeholder='значение'
                           required>
                    <!--                // id карточки (подставлять на js) к которой привязано слово будет-->
                    <input type='hidden' name='card_id' value=''>
                    <textarea class='form-control' name='definition' id='' cols='30' rows='2'
                              placeholder='определение, варианты использования'></textarea>

                </div>
                <div class='modal-footer'>
                    <!--clear-form button-->
                    <span class='btn btn-secondary dictionary-clear-form'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-x-square' viewBox='0 0 16 16'>
                          <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'/>
                          <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                        </svg>
                    </span>
                    <!--split-phrase button (word / pronunciation)-->
                    <span class='btn btn-outline-primary dictionary-split'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-align-center' viewBox='0 0 16 16'>
                          <path d='M8 1a.5.5 0 0 1 .5.5V6h-1V1.5A.5.5 0 0 1 8 1zm0 14a.5.5 0 0 1-.5-.5V10h1v4.5a.5.5 0 0 1-.5.5zM2 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7z'/>
                        </svg>
                    </span>

                    <!--save (submit) button-->
                    <button type='submit' class='btn btn-primary'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-save2' viewBox='0 0 16 16'>
                            <path d='M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z'></path>
                        </svg>
                    </button>
                    <!--close button-->
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
            </form>

        </div>
    </div>
</div>


<!--Add to cloud-->
<div class='modal fade' id='toCloud' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='toCloudLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
<!--            <div class='modal-header'>-->
<!--                <h5 class='modal-title' id='toCloudLabel'>Добавить в Облако</h5>-->
<!--                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>-->
<!--            </div>-->

            <div class="result"></div>

            <form id="form" class='default clear' action='/cards/cloud' method='post'>
                <div class='modal-body'>
                    <textarea class='form-control' name='cloud' cols='30' rows='5' required></textarea>
                </div>
                <div class='modal-footer'>
                    <span class='btn btn-secondary dictionary-clear-form'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-x-square' viewBox='0 0 16 16'>
  <path d='M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z'></path>
  <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'></path>
</svg>
                    </span>
                    <button type='submit' class='btn btn-primary'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-save2' viewBox='0 0 16 16'>
                            <path d='M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z'></path>
                        </svg>
                    </button>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
            </form>

        </div>
    </div>
</div>


<!--Remove word from dictionary-->
<div class='modal fade' id='del_word' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='del_wordLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='result'></div>

            <form id='form' class='default' action='/dictionary/delete/' method='post'>
                <input type="hidden" name="id" value="">
                <div class='modal-body'>
                    Удалить слово из словаря?
                </div>
                <div class='modal-footer'>
                    </span>
                    <button type='submit' class='btn btn-primary'>
                        Да
                    </button>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
            </form>

        </div>
    </div>
</div>

<!--Login form-->
<div class='modal fade' id='auth' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='authLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='result'></div>
            <div class="auth_wrap">
                <div class='modal-header'>
                    <h5 class='modal-title' id='authLabel'>Авторизация</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>

                <!--login-->
                <form id='form' class='auth' action='/user/auth' method='post'>
                    <div class='modal-body'>
                        <input class='form-control' type='text' name='login'>
                        <input class='form-control' type='password' name='passwd'>
                    </div>

                    <div class='modal-footer'>
                        <span class="register_form_show btn btn-outline-primary">Регистрация</span>
                        <button type='submit' class='btn btn-primary'>Войти</button>
                    </div>
                </form>
            </div>
            <div class="register_wrap" style="display: none">
                <!--Registration-->
                <div class='modal-header'>
                    <h5 class='modal-title' id='authLabel'>Регистрация</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <form id='form' class='register' action='/user/register' method='post'>
                    <div class='modal-body'>
                        <input class='form-control' type='text' name='name' placeholder='Имя'>
                        <input class='form-control' type='text' name='login' placeholder='Логин'>
                        <input class='form-control' type='email' name='email' placeholder='E-mail'>
                        <input class='form-control' type='password' name='passwd' placeholder='Пароль'>
                    </div>

                    <div class='modal-footer'>
                        <button type='submit' class='btn btn-primary'>Зарегистрироваться</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>

<!--edit a dictionary word-->
<div class='modal fade' id='edit_word' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='edit_wordLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='result'></div>

            <form id='form' class='default word-edit' action='/dictionary/edit' method='post'>
                <input type='hidden' name='id' value=''>
                <div class='modal-body'>
                  <input type="hidden" name="id">
                  <input class="form-control" type="text" name="word">
                  <input class='form-control' type="text" name="pronounce">
                  <input class='form-control' type="text" name="meaning">
                  <textarea class='form-control' name="definition" id="" cols="30" rows="2"></textarea>
                </div>
                <div class='modal-footer'>
                    </span>
                    <button type='submit' class='btn btn-primary'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-save2' viewBox='0 0 16 16'>
                            <path d='M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z'></path>
                        </svg>
                    </button>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
            </form>

        </div>
    </div>
</div>


<!--Show cards containing this word-->
<div class='modal fade' id='find_cards' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='find_cardsLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='result'></div>

            <div class='modal-header'>
                <h5 class='modal-title' id='toDictionaryLabel'>
                    Встречается в карточках:
                </h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>

            <div class='modal-body'>
                Modal body
            </div>
            <div class='modal-footer'></div>

        </div>
    </div>
</div>

<!--edit a card-->
<div class='modal fade' id='edit_card' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1'
     aria-labelledby='edit_cardLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
            <div class='result'></div>

            <form id='form' class='default edit_card' action='/cards/edit' method='post'>
                <input type='hidden' name='id' value=''>
                <div class='modal-body'>
                    <textarea class='form-control' name='top' cols='30' rows='2'></textarea>
                    <textarea class='form-control' name='back' cols='30' rows='2'></textarea>
                </div>
                <div class='modal-footer'>
                    <div class='reverse btn btn-outline-primary'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-arrow-repeat' viewBox='0 0 16 16'>
                            <path d='M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z'></path>
                            <path fill-rule='evenodd'
                                  d='M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z'></path>
                        </svg>
                    </div>

                    <button type='submit' class='btn btn-primary'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-save2' viewBox='0 0 16 16'>
                            <path d='M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z'></path>
                        </svg>
                    </button>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
            </form>

        </div>
    </div>
</div>
