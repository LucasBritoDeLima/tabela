$(() => {
  $.getJSON("/brand", (data) => {
    let items = [];

    $(data).each((key, value) => {
      console.log(value.name);
      items.push(value.name);
    });

    $("#brandName").autocomplete({
      source: items
    });

  });
});