$(document).ready(function () {
    $(".topic_stats_toggle").click(function (e) {
        e.preventDefault();

        $(".topic_stats_middle").toggleClass("isExpanded");
        $(".topic_stats_ulist").toggleClass("isExpanded");
        $(".topic_stats_dlist").toggleClass("isExpanded");

        $(".topic_stats_toggle").toggleClass("expanded");

        $(".topic_stats_toggle i").toggleClass("rotate");
    });
});
