/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/FileManagement/Resources/assets/js/form-procurement/pr-create.js":
/*!**********************************************************************************!*\
  !*** ./Modules/FileManagement/Resources/assets/js/form-procurement/pr-create.js ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  //Initialize Select2 Elements
  $(".select2").select2({
    placeholder: "Select from list"
  });
});
var createRequest = new Vue({
  el: '#procurement-request-create',
  data: {
    itemCount: ''
  },
  methods: {
    addNewRow: function addNewRow() {
      var rowElement = document.getElementById('pr-create');
      rowElement.insertAdjacentHTML('beforeEnd', "\n\n            <hr>\n\n            <div class=\"row\">\n                <div class=\"col-xl-3\">\n                    <div class=\"form-group\">\n                        <label>Stock Number</label>\n                        <input type=\"text\" name=\"stock[]\" class=\"form-control\">\n                    </div>\n                </div>\n                <div class=\"col-xl-3\">\n                    <div class=\"form-group\">\n                        <label>Unit</label>\n                        <input type=\"text\" name=\"unit[]\" class=\"form-control\">\n                    </div>\n                </div>\n                <div class=\"col-xl-3\">\n                    <div class=\"form-group\">\n                        <label>Quantity</label>\n                        <input type=\"number\" name=\"qty[]\" class=\"form-control\">\n                    </div>\n                </div>\n                <div class=\"col-xl-3\">\n                    <div class=\"form-group\">\n                        <label>Item Cost</label>\n                        <input type=\"number\" name=\"cost[]\" class=\"form-control\" step=\"0.01\" required>\n                    </div>\n                </div>\n                <div class=\"col-xl-12\">\n                    <div class=\"form-group\">\n                        <label for=\"\">Item Description</label>\n                        <textarea name=\"desc[]\" rows=\"2\" class=\"form-control\" required></textarea>\n                    </div>\n                </div>\n            </div>\n            ");
      this.itemCount += 1;
    },
    deleteLastRow: function deleteLastRow() {
      if (this.itemCount > 1) {
        var rowElement = document.getElementById('pr-create');
        rowElement.removeChild(rowElement.lastElementChild);
        rowElement.removeChild(rowElement.lastElementChild);
        this.itemCount -= 1;
      }
    },
    countRows: function countRows() {
      var rows = document.querySelectorAll('#pr-create > .row');
      this.itemCount = rows.length;
    }
  },
  created: function created() {
    this.countRows();
  }
});

/***/ }),

/***/ 8:
/*!****************************************************************************************!*\
  !*** multi ./Modules/FileManagement/Resources/assets/js/form-procurement/pr-create.js ***!
  \****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/xijeixhan/Desktop/mis/Modules/FileManagement/Resources/assets/js/form-procurement/pr-create.js */"./Modules/FileManagement/Resources/assets/js/form-procurement/pr-create.js");


/***/ })

/******/ });