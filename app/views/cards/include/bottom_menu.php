<?php
if(isset($panel['cards_to_study']))
    $cards = $panel['cards_to_study'];
else $cards = false;
if(isset($panel['cloud_items']))
    $cloud = $panel['cloud_items'];
else $cloud = false;
?>

<div class='row'> <!--menu-->
    <div class='header'>
        <nav class='navbar fixed-bottom navbar-light bg-light'>
            <div class='container'>


                <? if($_SERVER['REQUEST_URI'] !== '/cards/' && false): ?>
                <a type="buttom" class='btn btn-outline-primary' href='/cards/'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-house' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd'
                              d='M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z'/>
                        <path fill-rule='evenodd'
                              d='M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z'/>
                    </svg>
                </a>
                <? endif; ?>
                <? if($_SERVER['REQUEST_URI'] !== '/cards/add'):?>
                <a type="buttom" class='btn btn-outline-primary' href='/cards/add'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-file-earmark-plus' viewBox='0 0 16 16'>
                        <path d='M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z'/>
                        <path d='M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z'/>
                    </svg>
                </a>
                <? endif;?>
                <a class='btn btn-outline-<?if($cards):?>primary<?else:?>secondary<?endif;?>' href='/cards/list'>
                    <? if(isset($panel['cards_to_study']) && $_SERVER['REQUEST_URI'] !== '/cards/cloudList/'): ?>
                        <span class='badge bg-<?if($cards):?>primary<?else:?>secondary<?endif;?> rounded-pill'><?=$panel['cards_to_study'];
                        ?></span>
                    <? endif; ?>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-activity' viewBox='0 0 16 16'>
                        <path fill-rule='evenodd'
                              d='M6 2a.5.5 0 0 1 .47.33L10 12.036l1.53-4.208A.5.5 0 0 1 12 7.5h3.5a.5.5 0 0 1 0 1h-3.15l-1.88 5.17a.5.5 0 0 1-.94 0L6 3.964 4.47 8.171A.5.5 0 0 1 4 8.5H.5a.5.5 0 0 1 0-1h3.15l1.88-5.17A.5.5 0 0 1 6 2Z'/>
                    </svg>
                </a>

                <div>
                    <button type='button' class='btn btn-outline-primary' data-bs-toggle='modal' data-bs-target='#toCloud'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-cloud-arrow-down' viewBox='0 0 16 16'>
                            <path fill-rule='evenodd'
                                  d='M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708l2 2z'></path>
                            <path d='M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z'></path>
                        </svg>
                    </button>
                </div>

                <? if ($_SERVER['REQUEST_URI'] !== '/cards/cloudList'): ?>
                <div>
                    <a <?if($cloud):?>href='/cards/cloudList'<?endif;?> class='btn btn-outline-<?if($cloud)
                        :?>primary<?else:?>secondary<?endif;?>'>
                        <span class='badge bg-<?if($cloud):?>primary<?else:?>secondary<?endif;?> rounded-pill'>
                            <? if(isset($panel)) echo $panel['cloud_items'];?>
                        </span>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-eye' viewBox='0 0 16 16'>
                            <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z'/>
                            <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z'/>
                        </svg>

                    </a>

                </div>
                <? endif; ?>

                <div>
                    <a class='btn btn-outline-success' data-bs-toggle='modal'
                       data-bs-target='#toDictionary'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                             class='bi bi-plus' viewBox='0 0 16 16'>
                            <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'></path>
                        </svg>
                    </a>
                </div>

                <?if($_SERVER["REQUEST_URI"] == "/cards/cloud"):?>
                <button class='btn btn-outline-primary'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'
                         class='bi bi-save2' viewBox='0 0 16 16'>
                        <path d='M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z'/>
                    </svg>
                </button>
                <? endif; ?>
            </div> <!--container-->

        </nav>
    </div>
</div>
