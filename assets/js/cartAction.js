import { postForm } from "../helpers/request.js";
import { toast } from "../UI/toast.js";

export const initCartAction = () => {
  document.addEventListener("click", async (e) => {
    const rm = e.target.closest("[data-cart-remove]");
    if (!rm) return;

    const id = rm.dataset.cartRemove;
    const data = await postForm("/cart_api.php", {
      action: "remove",
      cart_item_id: id
    });

    data.ok
      ? toast("Removed", "ok")
      : toast("Remove failed", "err");
  });
};