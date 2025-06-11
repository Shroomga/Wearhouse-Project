function openForm(id) {
  $(`#${id} .account-display button`).on("click", function () {
    $(`#${id} .account-display`).addClass("hidden");
    $(`#${id} .account-form`).removeClass("hidden");
  });
}

function closeForm(id) {
  $(`#${id} .account-form button:contains("Cancel")`).on("click", function () {
    $(`#${id} .account-form`).addClass("hidden");
    $(`#${id} .account-display`).removeClass("hidden");
  });
}
function formControl(id) {
  openForm(id);
  closeForm(id);
}
formControl("fullname");
formControl("email");
formControl("phone-number");
formControl("address");
