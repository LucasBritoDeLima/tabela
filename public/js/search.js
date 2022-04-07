$(document).ready(() => {
  $("#form-cars").click((e) => e.preventDefault())
  var input = $("#brandName").val();
  let uri = "/car?name=" + input;
  $("#sendButton").click(() => {
    console.log(input);
    $.getJSON(uri, (data) => {
      let brands = [];

      $(data).each((key,value) => {
        console.log(value);
      });
    });
  });
}
);

$(() => {
  $.getJSON("/brand", (data) => {
    let items = [];

    $(data).each((key, value) => {
      //console.log(value.name);
      items.push(value.name);
    });

    $("#brandName").autocomplete({
      source: items
    });
  });
});