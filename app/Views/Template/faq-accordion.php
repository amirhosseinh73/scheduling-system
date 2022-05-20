<div class="accordion accordion-flush" id="faq_accordion">
    <?php
    if ( exists( $faq ) && is_array( $faq ) ) :
        foreach( $faq as $idx => $qa ) :
            echo "
            <section class='accordion-item'>
                <h2 class='accordion-header' id='faq_q_$idx'>
                    <button class='accordion-button " . ( $idx !== 0 ? 'collapsed' : '' ) . "' type='button' data-bs-toggle='collapse' 
                    data-bs-target='#faq_a_$idx' aria-expanded='false' aria-controls='faq_a_$idx'>$qa->question</button>
                </h2>
                <div id='faq_a_$idx' class='accordion-collapse collapse " . ( $idx !== 0 ? '' : 'show' ) . "' aria-labelledby='faq_q_$idx' 
                data-bs-parent='#faq_accordion'>
                    <div class='accordion-body'>$qa->answer</div>
                </div>
            </section>";
        endforeach;
    endif;
    ?>
</div>