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

/***/ "./resources/assets/js/App/addToCart.js":
/*!**********************************************!*\
  !*** ./resources/assets/js/App/addToCart.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('.cart-form').on('submit', function (e) {
    e.preventDefault();
    var url = $(this).attr('action'),
        productId = $(this).find('input[name="id"]').val();
    axios.post(url, {
      productId: productId
    }).then(function (response) {
      if (response.status === 201) {
        showConfirmMessage();
        $('.cartConfirm').on('click', function () {
          window.location.replace(response.data.redirect);
        });
      } else if (response.status === 204) {
        showNoteMessage();
      }

      $('.cartCancel').on('click', function () {
        removeMessage();
      });
    }).catch(function (error) {
      if (error.response.status === 401) {
        message = 'Login first please!';
      } else if (error.response.status >= 500) {
        message = 'Something wrong happend, please try again later!';
      }

      $('.messageTop').text(message).fadeIn();
      setTimeout(function () {
        $('.messageTop').fadeOut();
      }, 3000);
    });
  });

  function showConfirmMessage() {
    prepareMessage();
    $('.messageConfirm').show().prepend("\n            <p>The product has been added to your cart.</p>\n            <button class='cartConfirm btn btn-success'>View Cart and Checkout</button>\n            <button class='cartCancel btn btn-primary'>Continue Shopping</button>\n        ");
  }

  function showNoteMessage() {
    prepareMessage();
    $('.messageConfirm').show().prepend("\n            <p>This product does not have more available stock.</p>\n            <button class='cartCancel btn btn-primary'>Continue Shopping</button>\n        ");
  }

  function prepareMessage() {
    $('body').css('overflow', 'hidden');
    $('.opacityBackground').show();
  }

  function removeMessage() {
    $('body').css('overflow', 'visible');
    $('.opacityBackground').hide();
    $('.messageConfirm').hide();
    $('.messageConfirm').children().remove();
  }
});

/***/ }),

/***/ 8:
/*!****************************************************!*\
  !*** multi ./resources/assets/js/App/addToCart.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/lacommerce/resources/assets/js/App/addToCart.js */"./resources/assets/js/App/addToCart.js");


/***/ })

/******/ });