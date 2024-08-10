/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
$(".option").click(function () {
  $('.next').attr('disabled', false);
});
$(function () {
  $('.loading-section').fadeOut().removeClass("loader");
  $('#loading').fadeOut();
  $(".show-dropdown, .categories_menu").mouseenter(function () {
    $(".categories_menu").show();
  });
  $(".show-dropdown, .categories_menu").mouseleave(function () {
    $(".categories_menu").hide();
  });
});
/******/ })()
;