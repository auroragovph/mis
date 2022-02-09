/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************************!*\
  !*** ./resources/js/helpers/tom-select.init.js ***!
  \*************************************************/
document.addEventListener("DOMContentLoaded", function (e) {
  var toms = document.querySelectorAll(".tom-select");
  toms.forEach(function (tom) {
    new TomSelect(tom, {
      create: false,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
  });
});
/******/ })()
;