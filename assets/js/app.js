import { initQtyControl } from "./UI/qty.js";
import { initAddToCart } from "./Cart/addtoCart.js";
import { initCartAction } from "./Cart/cartAction.js";
import { initLogger } from ".modules/logger.js";

(() => {
  initQtyControl();
  initAddToCart();
  initCartAction();
  initLogger();
})();