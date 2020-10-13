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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./Modules/FileManagement/Resources/assets/js/form-afl/form-afl-edit-sick.js":
/*!***********************************************************************************!*\
  !*** ./Modules/FileManagement/Resources/assets/js/form-afl/form-afl-edit-sick.js ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  //Initialize Select2 Elements
  $(".select2").select2({
    placeholder: "Select from list"
  });
  $('#datepicker').datepicker({
    multidate: true,
    clearBtn: true
  });
});
var createCafoa = new Vue({
  el: '#app-root',
  data: {
    v1: parseFloat(document.querySelector("input[name=v1]").value),
    v2: parseFloat(document.querySelector("input[name=v2]").value),
    s1: parseFloat(document.querySelector("input[name=s1]").value),
    s2: parseFloat(document.querySelector("input[name=s2]").value),
    vacation: {
      type: '',
      details: ''
    },
    sick: {
      inh: false
    }
  },
  watch: {
    v1: function v1() {
      return this.v1 = parseFloat(this.v1);
    },
    v2: function v2() {
      return this.v2 = parseFloat(this.v2);
    },
    s1: function s1() {
      return this.s1 = parseFloat(this.s1);
    },
    s2: function s2() {
      return this.s2 = parseFloat(this.s2);
    }
  },
  methods: {
    sickC: function sickC() {
      if (document.querySelector('#sic-mut').value == 'true') {
        return this.sick.inh = true;
      } else {
        return this.sick.inh = false;
      } // console.log(document.querySelector('#sic-mut').value);

    }
  },
  mounted: function mounted() {
    this.sickC();
  }
});

/***/ }),

/***/ 4:
/*!*****************************************************************************************!*\
  !*** multi ./Modules/FileManagement/Resources/assets/js/form-afl/form-afl-edit-sick.js ***!
  \*****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/xijeixhan/Desktop/mis/Modules/FileManagement/Resources/assets/js/form-afl/form-afl-edit-sick.js */"./Modules/FileManagement/Resources/assets/js/form-afl/form-afl-edit-sick.js");


/***/ })

/******/ });