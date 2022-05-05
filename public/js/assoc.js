$(document).ready(function () {
  $.get("/jointwo", function (data) {
    $("#table-heads").empty();
    for (let i = 0; i < data.length; i++) {
      $("#table-heads").append(`
        <tr>
          <td class="title-car">
            ${data[i].carName} &rarr; ${data[i].cylinderHead}
          </td>
          <td class="btn-align">
            <button class="btn-del" id='${data[i].idJoin}'>Apagar</button>
          </td>
        </tr>
      `);
    }
  });
});

$(document).on("click", ".btn-del", function (e) {
  e.preventDefault();
  var id = $(this).attr("id");
  var tr = $(this).closest("tr");
  $.ajax({
    url: "/app/hide-head",
    method: "POST",
    data: { idJoin: id },
    success: function (data) {
      alert(data);
      tr.fadeOut(1200, function () {
        tr.remove();
      });
    },
  });
});

function loadData() {
  term = document.getElementById("assHead").value;

  $.ajax({
    type: "POST",
    dataType: "json",
    url: "/app/search-join",
    beforeSend: () => console.log("carregando"),
    data: { search: term },
    success: (data) => {
      let tableHead = $("#table-heads");
      tableHead.empty();
      console.log(data);
      for (let i = 0; i < data.length; i++) {
        console.log(data[i].name_engine);
        tableHead.append(`<tr>
                            <td class="title-car">
                            ${data[i].carName} &rarr; ${data[i].cylinderHead}
                            </td>
                            <td class="btn-align">
                            <button class="btn-del" id='${data[i].idJoin}'>Apagar</button>
                            </td>
                          </tr>`);
      }
    },
  });
}

$("#assHead").keyup(() => {
  loadData();
});
