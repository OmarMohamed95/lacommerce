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

/***/ "./resources/assets/js/App/review.js":
/*!*******************************************!*\
  !*** ./resources/assets/js/App/review.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('#review').on('submit', function (e) {
    e.preventDefault();
    var content = $('textarea[name="content"]').val(),
        url = $(this).attr('action');
    axios.post(url, {
      content: content
    }).then(function (response) {
      $('#errorMsg').hide();
      var review = response.data.review,
          date = dateToStr(review.created_at);
      renderReview(review, date);
    }).catch(function (error) {
      if (error.response.status === 422) {
        showErrorMessage(error.response.data.content[0]);
      } else if (error.response.status === 401) {
        showErrorMessage('Please login to be able to review the product');
      }
    });
  });

  function showErrorMessage(message) {
    $('#errorMsg').show();
    $('#errorMsg').addClass('alert alert-danger text-center').text(message);
  }

  function dateToStr(date) {
    var date = new Date(date),
        options = {
      weekday: 'short',
      month: 'long',
      day: 'numeric',
      year: 'numeric'
    };
    return date.toLocaleDateString(false, options);
  }

  function renderReview(review, date) {
    $('.showReviews').prepend("\n            <div class='singleReview'>\n                <p class='pull-right'>".concat(date, "</p> \n                <p class='reviewName'>").concat(review.user.name, "</p> \n                <p>").concat(review.content, "</p>\n            </div>\n        "));
  }
});

/***/ }),

/***/ 4:
/*!*************************************************!*\
  !*** multi ./resources/assets/js/App/review.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/lacommerce/resources/assets/js/App/review.js */"./resources/assets/js/App/review.js");


/***/ })

/******/ });