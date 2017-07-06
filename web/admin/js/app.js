$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");


    var elems = Array.prototype.slice.call(document.querySelectorAll('[data-toggle=switcher]'));
    elems.forEach(function(html) {
        var disabled = !!$(html).data('switcher-disabled');
        var size = $(html).data('switcher-size') || 'small';
        var switchery = new Switchery(html,{ size: size, disabled:disabled, disabledOpacity:0.5 });
        $(html).data('switchery', switchery);
    });

})

