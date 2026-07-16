<?php 
    $section_bg_color  = get_sub_field('bg_color');
    $custom_class  = get_sub_field('custom_class');
?>
<section class="contact_column appointgem-wrap <?php echo $custom_class; ?>" style="background-color: <?php echo $section_bg_color ?>;">
    <div class="appointgem-container">
        <div class="appointgem-container-inner">
            <?php if( have_rows('contact_form') ) : ?>
                <?php while( have_rows('contact_form') ) : the_row(); 
                    $contact_section = get_sub_field('contact_section'); 
                    $contact_form_title  = get_sub_field( 'contact_form_title' );
                    $contact_description  = get_sub_field( 'contact_description' );
                    $contact_form  = get_sub_field('select_contact_form');
                ?>
                    <div class="row">  
                            <div class="col-lg-6 detailWrap">
                                <?php foreach ($contact_section as $item) : 
                                    $type = $item['type'];
                                    $text = $item['text'];
                                    $company_details = $item['company_details'];
                                    ?>
                                <div class="detail">
                                    <?php if($type == "Text" && !empty($text)) :?>
                                        <div class="detail-content">
                                            <?php echo $text; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($type == "Company Details" && !empty($company_details)) : ?>
                                        <ul>
                                            <?php foreach ($company_details as $detail) : ?>
                                                <?php if ($detail['type'] === 'Phone' && !empty($detail['phone'])) : ?>
                                                    <li>
                                                        <a href="tel:<?php echo preg_replace('/\s+/', '', $detail['phone']); ?>" title="Call us">
                                                            <i class="bx bx-phone"></i> <?php echo $detail['phone']; ?>
                                                        </a>
                                                    </li>
                                                <?php elseif ($detail['type'] === 'Email' && !empty($detail['email'])) : ?>
                                                    <li>
                                                        <a href="mailto:<?php echo $detail['email']; ?>" title="Email us">
                                                            <i class="bx bx-envelope"></i> <?php echo $detail['email']; ?>
                                                        </a>
                                                    </li>
                                                <?php elseif ($detail['type'] === 'Address' && !empty($detail['address'])) : ?>
                                                    <li>
                                                        <div class="address" title="Visit us">
                                                            <i class="bx bx-map"></i> <?php echo $detail['address']; ?>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <div class="col-lg-6 contactFromWrap">
                            <div class="FromWrap">
                                <?php  if($contact_form_title) : ?>
                                    <div class="column-main-title">
                                        <?php  if($contact_form_title) : ?>
                                            <h3><?php echo $contact_form_title; ?></h3>
                                        <?php endif; ?>
                                    </div>
                                    <div class="description">
                                        <?php  if($contact_description) : ?>
                                            <?php echo $contact_description; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php echo $contact_form; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>	
        </div>
    </div>
</section>