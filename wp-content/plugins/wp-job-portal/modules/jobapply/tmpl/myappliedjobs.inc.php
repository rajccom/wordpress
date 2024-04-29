<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script>
    function toggleCommentsDivById(divid) {
        jQuery("div#" + divid).slideToggle();
    }

    jQuery(document).ready(function () {
        jQuery('a.sort-icon').click(function (e) {
            changeSortBy();
        });
     });

    function changeSortBy() {
        var value = jQuery('a.sort-icon').attr('data-sortby');
        var img = '';
        if (value == 1) {
            value = 2;
            img = jQuery('a.sort-icon').attr('data-image2');
        } else {
            img = jQuery('a.sort-icon').attr('data-image1');
            value = 1;
        }
        jQuery("img#sortingimage").attr('src', img);
        jQuery('input#sortby').val(value);
        jQuery('form#job_form').submit();
    }
        
    function changeCombo() {
        jQuery("input#sorton").val(jQuery('select#sorting').val());
        changeSortBy();
    }
</script>
