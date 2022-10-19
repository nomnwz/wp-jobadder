<?php
/**
 * Jobadder Functions
 *
 * @since 1.0
 */

defined( 'ABSPATH' ) || die( 'You are not allowed to access.' ); // Terminate if accessed directly

/**
 * Get jobadder api jobs
 * 
 * @param array $args
 * 
 * @return array The jobs array
 */
function bh2ojaa_get_jobadder_jobs( $args = array() ) {
    $jobadder_api 	= new BH2OJAA();

    return json_decode( $jobadder_api->get_jobs( $args ) );
}

/**
 * Get a jobadder api job
 * 
 * @param int $job_id
 * 
 * @return object The job object
 */
function bh2ojaa_get_jobadder_job( $job_id ) {
    $jobadder_api 	= new BH2OJAA();

    return json_decode( $jobadder_api->get_job( $job_id ) );
}

/**
 * Get jobadder api job ads
 * 
 * @param array $args
 * 
 * @return array The job ads array
 */
function bh2ojaa_get_jobadder_job_ads( $args = array() ) {
    $jobadder_api 	= new BH2OJAA();

    return json_decode( $jobadder_api->get_job_ads( $args ) );
}

/**
 * Get a jobadder api job ad
 * 
 * @param int $ad_id
 * 
 * @return object The job ad object
 */
function bh2ojaa_get_jobadder_job_ad( $ad_id ) {
    $jobadder_api 	= new BH2OJAA();

    return json_decode( $jobadder_api->get_job_ad( $ad_id ) );
}

/**
 * Apply for a job
 * 
 * @param int $ad_id
 * @param array $data
 * 
 * @return string The response data
 */
function bh2ojaa_apply_for_job( $ad_id, $data ) {
    $jobadder_api   = new BH2OJAA();

    return json_decode( $jobadder_api->apply_for_job( $ad_id, $data ) );
}

/**
 * Submit document in a job application
 * 
 * @param int $ad_id
 * @param int $application_id
 * @param string $attachment_type
 * @param array $data
 * 
 * @return string The response data
 */
function bh2ojaa_submit_documents_for_job_application( $ad_id, $application_id, $attachment_type, $data ) {
    $jobadder_api   = new BH2OJAA();

    return json_decode( $jobadder_api->submit_documents_for_job_application( $ad_id, $application_id, $attachment_type, $data ) );
}

/**
 * Enqueue styles and scripts
 */
add_action( 'wp_enqueue_scripts', 'bh2ojaa_enqueue_scripts' );
function bh2ojaa_enqueue_scripts() {
    wp_enqueue_style( 'bh2ojaa-style', plugin_dir_url( BH2OJAA_PLUGIN_FILE ) . 'assets/css/bh2ojaa.css', array(), BH2OJAA_PLUGIN_VERSION );
    wp_enqueue_script( 'bh2ojaa-script', plugin_dir_url( BH2OJAA_PLUGIN_FILE ) . 'assets/js/bh2ojaa.js', array( 'jquery' ), BH2OJAA_PLUGIN_VERSION, true );

    wp_localize_script( 'bh2ojaa-script', 'wp_obj', array(
        'ajax_url' 		=> admin_url( 'admin-ajax.php' ),
        'admin_images'	=> admin_url( 'images' )
    ) );
}

/**
 * Add shortcode for doctor job ads
 * 
 * @param array $atts
 */
add_shortcode( 'bh2ojaa_doctor_jobs', 'bh2ojaa_get_doctor_job_ads' );
function bh2ojaa_get_doctor_job_ads( $atts = array() ) {
    $atts = shortcode_atts( array(
        'post_type'         => 'jobadder_job_ads',
        'posts_per_page'    => -1,
        'tax_query'         => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => 'Medical Practitioner'
            )
        )
    ), $atts );

    ob_start();

    bh2ojaa_search_form( 'Medical Practitioner' );

    bh2ojaa_job_ad_loop( $atts );

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
}

/**
 * Add shortcode for nurse job ads
 * 
 * @param array $atts
 */
add_shortcode( 'bh2ojaa_nurse_jobs', 'bh2ojaa_get_nurse_job_ads' );
function bh2ojaa_get_nurse_job_ads( $atts = array() ) {
    $atts = shortcode_atts( array(
        'post_type'         => 'jobadder_job_ads',
        'posts_per_page'    => -1,
        'tax_query'         => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => 'Nurse / Midwive'
            )
        )
    ), $atts );

    ob_start();

    bh2ojaa_search_form( 'Nurse / Midwive' );

    bh2ojaa_job_ad_loop( $atts );

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
}

/**
 * Add shortcode for receptionist job ads
 * 
 * @param array $atts
 */
add_shortcode( 'bh2ojaa_receptionist_jobs', 'bh2ojaa_get_receptionist_job_ads' );
function bh2ojaa_get_receptionist_job_ads( $atts = array() ) {
    $atts = shortcode_atts( array(
        'post_type'         => 'jobadder_job_ads',
        'posts_per_page'    => -1,
        'tax_query'         => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => 'Reception/Admin'
            )
        )
    ), $atts );

    ob_start();

    bh2ojaa_search_form( 'Receptionist' );

    bh2ojaa_job_ad_loop( $atts );

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
}

/**
 * Add shortcode for management job ads
 * 
 * @param array $atts
 */
add_shortcode( 'bh2ojaa_management_jobs', 'bh2ojaa_get_management_job_ads' );
function bh2ojaa_get_management_job_ads( $atts = array() ) {
    $atts = shortcode_atts( array(
        'post_type'         => 'jobadder_job_ads',
        'posts_per_page'    => -1,
        'tax_query'         => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => 'Management'
            )
        )
    ), $atts );

    ob_start();

    bh2ojaa_search_form( 'Management' );

    bh2ojaa_job_ad_loop( $atts );

    $content = ob_get_contents();

    ob_end_clean();

    return $content;
}

/**
 * Prints the job ad loop
 * 
 * @param array get_posts $args
 */
function bh2ojaa_job_ad_loop( $args ) {
    if ( isset( $_GET['keyword'] ) ) {
        $args['s'] = $_GET['keyword'];
    }

    $my_query = new WP_Query( $args );

    if ( $my_query->have_posts() ) {
        ?>
        <div class="job_ads row mx-0">
            <?php
            while( $my_query->have_posts() ) {
                $my_query->the_post();

                $ad_id = get_the_ID();

                if ( isset( $_GET['location'] ) || isset( $_GET['work_type'] ) || isset( $_GET['dpa_status'] ) || isset( $_GET['mmn'] ) ) {
                    if ( isset( $_GET['location'] ) && !empty( $_GET['location'] ) ) {
                        $location = bh2ojaa_get_job_ad_portal_field( $ad_id, 'Location' );

                        if ( !str_contains( strtolower( $location ), strtolower( $_GET['location'] ) ) ) continue;
                    }

                    if ( isset( $_GET['work_type'] ) && !empty( $_GET['work_type'] ) ) {
                        $work_type = bh2ojaa_get_job_ad_portal_field( $ad_id, 'Work Type' );

                        if ( !str_contains( strtolower( $work_type ), strtolower( $_GET['work_type'] ) ) ) continue;
                    }

                    if ( isset( $_GET['dpa_status'] ) && !empty( $_GET['dpa_status'] ) ) {
                        $dpa_status = bh2ojaa_get_job_ad_portal_field( $ad_id, 'DPA Status' );

                        if ( !str_contains( strtolower( $dpa_status ), strtolower( $_GET['dpa_status'] ) ) ) continue;
                    }

                    if ( isset( $_GET['mmn'] ) && !empty( $_GET['mmn'] ) ) {
                        $mmn = bh2ojaa_get_job_ad_portal_field( $ad_id, 'Modified Monash Number' );

                        if ( !str_contains( strtolower( $mmn ), strtolower( $_GET['mmn'] ) ) ) continue;
                    }
                }

                bh2ojaa_job_ad_loop_item( $ad_id );
            }
            ?>
        </div>
        <?php
    } else {
        ?>
        <div class="job_ads row mx-0">
            <h4><?php _e( 'No job found!', 'bh2ojaa' ); ?></h4>
        </div>
        <?php
    }
    
    wp_reset_postdata();
}

/**
 * Prints the job ad loop item
 * 
 * @param int The job ad post ID
 */
function bh2ojaa_job_ad_loop_item( $ad_id ) {
    $thumbnail_src  = bh2ojaa_get_job_ad_portal_field( $ad_id, 'Image URL' );

    $bullet_points  = '';

    if ( $jobBulletPoints = get_post_meta( $ad_id, 'jobBulletPoints', true ) ) {
        $bullet_points = '<ul class="job-ad-points m-0 pl-3 ps-3">';

        foreach ( $jobBulletPoints as $point ) {
            $bullet_points .= '<li class="job-ad-point">' . $point . '</li>';
        }

        $bullet_points .= '</ul>';
    }

    $summary = get_post_meta( $ad_id, 'jobSummary', true );
    ?>
    <div class="job-ad-wrapper col-12 col-md-6 col-lg-4 p-0 mb-4">
        <div class="border rounded-bottom h-100 d-flex flex-column justify-content-between mr-3 me-3">
            <?php
            if ( $thumbnail_src ) {
                ?>
                <div class="job-ad-thumbnail mb-2">
                    <img src="<?php echo $thumbnail_src; ?>" alt="<?php echo get_the_title( $ad_id ); ?>">
                </div>
                <?php
            }
            ?>
            <div class="job-ad-details p-2">
                <div class="<?php echo $summary ? 'border-bottom border-danger pb-3' : ''; ?>">
                    <h5 class="job-ad-title pt-0 pb-0"><?php echo get_the_title( $ad_id ); ?></h5>
                    <p class="job-ad-location mb-0"><?php echo bh2ojaa_get_job_ad_portal_field( $ad_id, 'Location' ); ?></p>
                    <p class="job-ad-dpa-status mb-0"><?php echo bh2ojaa_get_job_ad_portal_field( $ad_id, 'DPA Status' ); ?></p>
                    <p class="job-ad-mmn mb-1"><?php echo bh2ojaa_get_job_ad_portal_field( $ad_id, 'Modified Monash Number' ); ?></p>
                </div>
                <div class="job-ad-summary py-3"><?php echo $summary; ?></div>
            </div>
            <div class="job-ad-footer d-flex flex-column justify-content-center p-2 border-top">
                <a class="text-decoration-none text-danger py-1 text-uppercase" href="<?php echo get_the_permalink( $ad_id ); ?>"><?php _e( 'Read more', 'bh2ojaa' ); ?> <i class="fas fa-arrow-right ml-3 ms-3"></i></a>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Get job ad portal field
 * 
 * @param int $ad_id
 * @param string $field_name
 * 
 * @return string
 */
function bh2ojaa_get_job_ad_portal_field( $ad_id, $field_name ) {
    $output = '';

    if ( $jobPortal  = get_post_meta( $ad_id, 'jobPortal', true ) ) {
        $field = array_values( array_filter( $jobPortal['fields'], function( $field ) use ( $field_name ) {
            return $field->fieldName === $field_name;
        } ) );

        if ( count( $field ) > 0 ) {
            $output = reset( $field )->value;
        }
    }

    return $output;
}

/**
 * Get job ad classification
 * 
 * @param int $ad_id
 * @param string $type
 * 
 * @return string
 */
function bh2ojaa_get_job_ad_classification( $ad_id, $type ) {
    $output = '';
    $cat    = bh2ojaa_get_job_ad_portal_field( $ad_id, 'Category' );

    if ( $type == 'Category' ) {
        $output = $cat;
    } else if ( $type == 'Sub Category' ) {
        if ( $jobPortal  = get_post_meta( $ad_id, 'jobPortal', true ) ) {
            $cat = array_values( array_filter( $jobPortal['fields'], function( $field ) {
                return $field->fieldName === 'Category';
            } ) );
    
            if ( count( $cat ) > 0 ) {
                $cat    = reset( $cat );
                $field  = array_values( array_filter( $cat->fields, function( $field ) {
                    return $field->fieldName === 'Sub Category';
                } ) );
        
                if ( count( $field ) > 0 ) {
                    $output = reset( $field )->value;
                }
            }
        }
    }

    return $output;
}

/**
 * Print a job apply modal
 * 
 * @param int $ad_id
 */
function bh2ojaa_job_apply_modal( $ad_id ) {
    ?>
    <div class="modal fade" id="jobApply<?php echo $ad_id; ?>" tabindex="-1" role="dialog" aria-labelledby="jobApply<?php echo $ad_id; ?>Label" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog" role="document" style="margin-top: calc(1.75rem + 86px) !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title py-0" id="jobApply<?php echo $ad_id; ?>Label"><?php echo get_the_title( $ad_id ); ?></h5>
                </div>
                <form class="job-apply-form" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="ad-id" value="<?php echo $ad_id; ?>">
                        <div class="mb-3">
                            <label for="firstname-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'First name', 'bh2ojaa' ); ?> *</label>
                            <input type="text" class="form-control" name="firstname" id="firstname-<?php echo $ad_id; ?>" placeholder="Enter your first name" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'Last name', 'bh2ojaa' ); ?> *</label>
                            <input type="text" class="form-control" name="lastname" id="lastname-<?php echo $ad_id; ?>" placeholder="Enter your last name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'Email address', 'bh2ojaa' ); ?> *</label>
                            <input type="email" class="form-control" name="email" id="email-<?php echo $ad_id; ?>" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="tel-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'Mobile', 'bh2ojaa' ); ?></label>
                            <input type="tel" class="form-control" name="tel" id="tel-<?php echo $ad_id; ?>" maxlength="16" minlength="10" placeholder="Enter your phone number">
                        </div>
                        <div class="mb-3">
                            <label for="gender-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'Gender', 'bh2ojaa' ); ?></label>
                            <select class="form-control" name="gender" id="gender-<?php echo $ad_id; ?>">
                                <option value="">-- <?php _e( 'Select..', 'bh2ojaa' ); ?> --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Prefer not to disclose">Prefer not to disclose</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="resume-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'Resume/CV', 'bh2ojaa' ); ?></label>
                            <input type="file" class="form-control bg-transparent border-0 text-white" name="resume" id="resume-<?php echo $ad_id; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="cover-type-<?php echo $ad_id; ?>" class="form-label"><?php _e( 'Cover note', 'bh2ojaa' ); ?></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cover-type" id="cover-type-<?php echo $ad_id; ?>-letter" value="cover-letter" checked="checked" onchange="jobCoverTypeCheck(this, <?php echo $ad_id; ?>)">
                                <label class="form-check-label" for="cover-type-<?php echo $ad_id; ?>-letter"><?php _e( 'Attach', 'bh2ojaa' ); ?></label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cover-type" id="cover-type-<?php echo $ad_id; ?>-note" value="cover-note" onchange="jobCoverTypeCheck(this, <?php echo $ad_id; ?>)">
                                <label class="form-check-label" for="cover-type-<?php echo $ad_id; ?>-note"><?php _e( 'Write now', 'bh2ojaa' ); ?></label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control bg-transparent border-0 text-white" name="cover-letter" id="cover-letter-<?php echo $ad_id; ?>">
                        </div>
                        <div class="mb-3" style="display: none;">
                            <textarea class="form-control" name="cover-note" id="cover-note-<?php echo $ad_id; ?>" rows="3" placeholder="Cover note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="form-message font-weight-bold fw-bold mb-3"></div>
                        <div class="form-actions">
                            <button type="submit" class="job-apply-submit btn btn-primary"><?php _e( 'Submit', 'bh2ojaa' ); ?></button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e( 'Close', 'bh2ojaa' ); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Insert a job ad
 * 
 * @param object The job ad object from API response
 * 
 * @return int|null The job ad ID
 */
function bh2ojaa_insert_job_ad( $ad ) {
    if ( !is_admin() && !wp_doing_cron() ) return new WP_Error( 401, __( 'User not logged in.', 'bh2ojaa' ) );

    $args = array(
        'fields'        => 'ids',
        'post_type'     => 'jobadder_job_ads',
        'meta_query'    => array(
            array(
                'key'   => 'jobAdId',
                'value' => $ad->adId
            )
        )
    );

    $my_query   = new WP_Query( $args );

    $cat        = array_values( array_filter( $ad->portal->fields, function( $field ) {
        return $field->fieldName === 'Category';
    } ) );

    if ( count( $cat ) > 0 ) {
        $cat    = reset( $cat );

        $subcat = array_values( array_filter( $cat->fields, function( $field ) {
            return $field->fieldName === 'Sub Category';
        } ) );

        if ( count( $subcat ) > 0 ) {
            $cat_name = reset( $subcat )->value;
        } else {
            $cat_name = $cat->value;
        }
    }

    $args = array(
        'post_type'     => 'jobadder_job_ads',
        'post_title'    => $ad->title,
        'post_date'     => date( 'Y-m-d H:i:s', strtotime( $ad->postedAt ) ),
        'post_content'  => property_exists( $ad, 'description' ) ? $ad->description : '',
        'post_status'   => 'publish'
    );

    if ( empty( $my_query->have_posts() ) ) {
        if ( wp_doing_cron() ) {
            $args['post_author'] = 1;
        }

        $post_id = wp_insert_post( $args );

        if ( $post_id ) {
            $access_token = get_option( 'bh2ojaa_options' )['bh2ojaa_options_access_token'];

            // insert post taxonomy
            wp_set_object_terms( $post_id, $cat_name, 'job_type' );
    
            // insert post meta
            foreach ( (array) $ad as $key => $value ) {
                if ( property_exists( $ad, $key ) ) {
                    if ( is_object( $ad->$key ) ) {
                        add_post_meta( $post_id, 'job' . ucwords( $key ), (array) $value );
                    } else {
                        add_post_meta( $post_id, 'job' . ucwords( $key ), $value );
                    }
                }
            }
    
            // // insert attachment
            // $attach_id = bh2ojaa_insert_attachment_from_url( $ad->company->links->logo . '?access_token=' . $access_token, $post_id );
    
            // // set job ad thumbnail
            // if ( $attach_id ) {
            //     set_post_thumbnail( $post_id, $attach_id );
            // }
        }
    } else {
        $my_query->the_post();

        $post_id    = get_the_ID();
        $args       = array_merge( array( 'ID' => $post_id ), $args );
        $post_id    = wp_update_post( $args );

        if ( $post_id ) {
            // insert post taxonomy
            wp_set_object_terms( $post_id, $cat_name, 'job_type' );

            // update post meta
            foreach ( (array) $ad as $key => $value ) {
                if ( property_exists( $ad, $key ) ) {
                    if ( is_object( $ad->$key ) ) {
                        update_post_meta( $post_id, 'job' . ucwords( $key ), (array) $value );
                    } else {
                        update_post_meta( $post_id, 'job' . ucwords( $key ), $value );
                    }
                }
            }
        }

        wp_reset_postdata();
    }

    return $post_id;
}

/**
 * Insert an attachment from a URL address.
 *
 * @param  string   $url            The URL address.
 * @param  int|null $parent_post_id The parent post ID (Optional).
 * @return int|false                The attachment ID on success. False on failure.
 */
function bh2ojaa_insert_attachment_from_url( $url, $parent_post_id = null ) {

    if ( FALSE === filter_var( $url, FILTER_VALIDATE_URL ) ) return false;

    $wp_upload_dir  = wp_upload_dir();
    $image_data     = file_get_contents( $url );
    $file_name      = $parent_post_id . '_' . rand( 10000, 99999 ) . '.png';

    if ( wp_mkdir_p( $wp_upload_dir['path'] ) ) {
        $file_path = $wp_upload_dir['path'] . '/' . $file_name;
    } else {
        $file_path = $wp_upload_dir['basedir'] . '/' . $file_name;
    }

    file_put_contents( $file_path, $image_data );

    $file_type = wp_check_filetype( $file_name, null );

    $post_info = array(
        'guid'              => $wp_upload_dir['url'] . '/' . $file_name,
        'post_mime_type'    => $file_type['type'],
        'post_title'        => sanitize_file_name( $file_name ),
        'post_content'      => '',
        'post_status'       => 'inherit',
    );

    // Create the attachment.
    $attach_id = wp_insert_attachment( $post_info, $file_path, $parent_post_id );

    // Include image.php.
    require_once ABSPATH . 'wp-admin/includes/image.php';

    // Generate the attachment metadata.
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

    // Assign metadata to attachment.
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

/**
 * Ajax action to apply for a job
 */
add_action( 'wp_ajax_jobadder_api_apply_for_job', 'bh2ojaa_ajax_jobadder_api_apply_for_job' );
add_action( 'wp_ajax_nopriv_jobadder_api_apply_for_job', 'bh2ojaa_ajax_jobadder_api_apply_for_job' );
function bh2ojaa_ajax_jobadder_api_apply_for_job() {
    $data   = $_POST['data'];
    $ad_id  = $form_data['ad_id'];

    $form_data = array();

    $form_data['firstName']     = $data['firstname'];
    $form_data['lastName']      = $data['lastname'];
    $form_data['email']         = $data['email'];
    $form_data['custom']        = new stdClass();

    if ( $data['tel'] ) {
        $form_data['mobile']    = $data['tel'];
    }

    if ( $data['gender'] ) {
        $form_data['custom']->candidate[] = array(
            'fieldId'   => 'customField_8',
            'value'     => $data['gender']
        );
    }

    $res = bh2ojaa_apply_for_job( get_post_meta( $ad_id, 'jobAdId', true ), $form_data );

    if ( is_wp_error( $res ) ) {
        wp_send_json_error( array(
            'message' => $res->get_error_message()
        ) );
    } else {
        $res    = json_decode( $res );

        $documents = array();

        if ( $data['resume'] ) {
            $documents[] = array(
                'type' => 'Resume',
                'data' => $data['resume']
            );
        }

        if ( $data['cover-letter'] ) {
            $documents[] = array(
                'type' => 'CoverLetter',
                'data' => $data['cover-letter']
            );
        } elseif ( $data['cover-note'] ) {
            $documents[] = array(
                'type' => 'CoverLetter',
                'data' => $data['cover-note']
            );
        }

        if ( count( $documents ) > 0 ) {
            foreach ( $documents as $document ) {
                $file_type  = $document['type'];
                $file_data  = $document['data'];
                $res        = bh2ojaa_submit_documents_for_job_application( get_post_meta( $ad_id, 'jobAdId', true ), $res->applicationId, $file_type, $file_data );
            
                if ( is_wp_error( $res ) ) {
                    wp_send_json_error( array(
                        'message' => $res->get_error_message()
                    ) );
                } else {
                    wp_send_json_success( $res );
                }
            }
        } else {
            wp_send_json_success( $res );
        }
    }

    wp_die();
}

/**
 * Job search form
 * 
 * @param string $job_type
 */
function bh2ojaa_search_form( $job_type ) {
    $fields = array(
        array(
            'id'            => 'location',
            'label'         => __( 'Location', 'bh2ojaa' ),
            'type'          => 'select',
            'placeholder'   => __( 'Select a Location', 'bh2ojaa' ),
            'options'       => bh2ojaa_get_locations( $job_type )
        )
    );

    if ( $job_type === 'Medical Practitioner' ) {
        $fields = array_merge( $fields, array(
            array(
                'id'            => 'dpa_status',
                'label'         => __( 'DPA Status', 'bh2ojaa' ),
                'type'          => 'select',
                'placeholder'   => __( 'Select a DPA Status', 'bh2ojaa' ),
                'options'       => bh2ojaa_get_dpa_statuses( $job_type )
            ),
            array(
                'id'            => 'mmn',
                'label'         => __( 'Modified Monash Number', 'bh2ojaa' ),
                'type'          => 'select',
                'placeholder'   => __( 'Select a Modified Monash Number', 'bh2ojaa' ),
                'options'       => bh2ojaa_get_mmns( $job_type )
            )
        ) );
    } elseif ( $job_type === 'Nurse / Midwive' || $job_type === 'Receptionist' || $job_type === 'Management' ) {
        $fields = array_merge( $fields, array(
            array(
                'id'            => 'work_type',
                'label'         => __( 'Work Type', 'bh2ojaa' ),
                'type'          => 'select',
                'placeholder'   => __( 'Select a Work Type', 'bh2ojaa' ),
                'options'       => bh2ojaa_get_work_types( $job_type )
            )
        ) );
    }

    $fields = array_merge( $fields, array(
        array(
            'id'            => 'keyword',
            'label'         => __( 'Keyword', 'bh2ojaa' ),
            'type'          => 'text',
            'placeholder'   => __( 'Enter a keyword', 'bh2ojaa' )
        )
    ) );
    ?>
    <div class="advance-search mb-5">
        <form action="<?php echo get_the_permalink(); ?>">
            <div class="form row mx-0">
                <div class="col-12 px-0 row mx-0">
                    <?php
                    foreach ( $fields as $field ) {
                        ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <?php
                            if ( $field['type'] == 'select' ) {
                                ?>
                                <select name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>" class="custom-select form-select">
                                    <option value=""><?php echo $field['placeholder']; ?></option>
                                    <?php
                                    foreach ( $field['options'] as $option ) {
                                        ?>
                                        <option value="<?php echo $option; ?>" <?php selected( ( isset( $_GET[$field['id']] ) ? $_GET[$field['id']] : '' ), $option, true ) ?>><?php echo $option; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <?php
                            } else {
                                ?>
                                <input type="<?php echo $field['type']; ?>" name="<?php echo $field['id']; ?>" class="form-control" placeholder="<?php echo $field['placeholder']; ?>" value="<?php echo isset( $_GET[$field['id']] ) ? $_GET[$field['id']] : ''; ?>">
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-12 px-0 d-flex justify-content-center align-items-center">
                    <div>
                        <button type="submit" class="btn-search btn btn-primary btn-md"><?php _e( 'Search', 'bh2ojaa' ); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
}

/**
 * Get locations
 * 
 * @param string $job_type
 *
 * @return array The locations
 */
function bh2ojaa_get_locations( $job_type ) {
    $job_ads = get_posts( array(
        'post_type'     => 'jobadder_job_ads',
        'numberposts'   => -1,
        'tax_query'     => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => $job_type
            )
        )
    ) );

    $locations = array();

    foreach ( $job_ads as $ad ) {
        $location = bh2ojaa_get_job_ad_portal_field( $ad->ID, 'Location' );

        if ( $location ) {
            $locations[] = $location;
        }
    }

    return array_unique( $locations );
}

/**
 * Get DPA Statuses
 * 
 * @param string $job_type
 *
 * @return array The DPA Statuses
 */
function bh2ojaa_get_dpa_statuses( $job_type ) {
    $job_ads = get_posts( array(
        'post_type'     => 'jobadder_job_ads',
        'numberposts'   => -1,
        'tax_query'     => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => $job_type
            )
        )
    ) );

    $statuses = array();

    foreach ( $job_ads as $ad ) {
        $dpa_status = bh2ojaa_get_job_ad_portal_field( $ad->ID, 'DPA Status' );

        if ( $dpa_status ) {
            $statuses[] = $dpa_status;
        }
    }

    return array_unique( $statuses );
}

/**
 * Get Modified Monash Numbers
 * 
 * @param string $job_type
 *
 * @return array The Modified Monash Numbers
 */
function bh2ojaa_get_mmns( $job_type ) {
    $job_ads = get_posts( array(
        'post_type'     => 'jobadder_job_ads',
        'numberposts'   => -1,
        'tax_query'     => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => $job_type
            )
        )
    ) );

    $mmns = array();

    foreach ( $job_ads as $ad ) {
        $mmn = bh2ojaa_get_job_ad_portal_field( $ad->ID, 'Modified Monash Number' );

        if ( $mmn ) {
            $mmns[] = $mmn;
        }
    }

    return array_unique( $mmns );
}

/**
 * Get Work Types
 * 
 * @param string $job_type
 *
 * @return array The Work Types
 */
function bh2ojaa_get_work_types( $job_type ) {
    $job_ads = get_posts( array(
        'post_type'     => 'jobadder_job_ads',
        'numberposts'   => -1,
        'tax_query'     => array(
            array(
                'taxonomy'  => 'job_type',
                'field'     => 'name',
                'terms'     => $job_type
            )
        )
    ) );

    $work_types = array();

    foreach ( $job_ads as $ad ) {
        $work_type = bh2ojaa_get_job_ad_portal_field( $ad->ID, 'Work Type' );

        if ( $work_type ) {
            $work_types[] = $work_type;
        }
    }

    return array_unique( $work_types );
}