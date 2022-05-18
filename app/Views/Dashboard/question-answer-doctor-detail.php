<article class="col align-content-center px-0 h-100">
    <div class="dashboard-main-container">
        <div class="col-12 h-100">
            <a href="<?= base_url( "/dashboard/question-answer/doctor" )?>" class="btn-back fas fa-arrow-alt-right"></a>
            <section class="dashboard-inside-container scroll height-scroll-less mt-5">
                <div class="col-12 h-100">
                    <div class="inside-container-center px-2 align-items-center">
                        <div class="col-12 text-start">
                            <button id="delete_QA" type="button" class="btn-color-3 mb-4">حذف پرسش</button>
                        </div>
                        <?php
                        if ( exists( $QA ) ) :
                            $question_text = nl2br( $QA->question );
                            echo "<section class='message-box left'>
                                <img src='$patient_info->image' class='profile-image'/>
                                <div class='details'>
                                    <time class='dir-ltr'>$QA->created_at</time>
                                    <span>$patient_info->fullname</span>
                                    <blockquote>
                                        $question_text
                                    </blockquote>
                                </div>
                            </section>";

                        if ( exists( $answers ) ) :
                            foreach ( $answers as $answer ) :
                                $answer_text = nl2br( $answer->answer );
                                if ( $answer->user_ID === $user_info->ID ) : //patient
                                    echo "<section class='message-box right'>
                                        <img src='$user_info->image' class='profile-image'/>
                                        <div class='details'>
                                            <time class='dir-ltr'>$answer->created_at</time>
                                            <blockquote>
                                                $answer_text
                                            </blockquote>
                                        </div>
                                    </section>";
                                else : //doctor
                                    echo "<section class='message-box left'>
                                        <img src='$patient_info->image' class='profile-image'/>
                                        <div class='details'>
                                            <time>$answer->created_at</time>
                                            <span>$patient_info->fullname</span>
                                            <blockquote>
                                                $answer_text
                                            </blockquote>
                                        </div>
                                    </section>";
                                endif;
                            endforeach;
                        endif;
                        ?>
                        <?php if ( $QA->status != 2 ) : ?>
                            <section id="create_qa_row" class="col-12 mt-5">
                                <div class="row mx-0 align-items-center">
                                    <div class="col-12 col-sm-6">
                                        <h5 class="title text-black">مطلب خود را بیان کنید.</h5>
                                    </div>
                                    <div class="col-12 col-sm-6 text-start">
                                        <button id="close_QA" type="button" class="btn-color-2">بستن پرسش</button>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <textarea id="textarea_QA" class="form-control" rows="10"></textarea>
                                    </div>
                                    <div class="col-12 col-sm-3 me-auto text-start mt-4">
                                        <button id="submit_QA" data-type="answer" type="button" class="btn-color-1">ثبت سوال</button>
                                    </div>
                                </div>
                            </section>
                        <?php else :?>
                                <p class="title small text-color-4">این پرسش بسته شده است!</p>
                        <?php endif;
                        endif;
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</article>