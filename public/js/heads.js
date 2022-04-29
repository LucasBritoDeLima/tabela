function openModal(head) {
  $("#info-head").fadeIn();
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(1000);
  const formData = document.querySelector("#form-car-new");
  formData.addEventListener("submit", (event) => {
    event.preventDefault();
  });
  $.get("/heads", (data) => {
    let heads = data.heads;
    $("#head-span").text(heads[head - 1].name_engine);
    $("#name-head").val(heads[head - 1].name_engine);
    $("#head-fuel").val(heads[head - 1].fuel);
    $("#material-head").val(heads[head - 1].material_kind);
    $("#std-head").val(heads[head - 1].standard_height);
    $("#min-head").val(heads[head - 1].minimum_height);
    $("#obs-head").val(heads[head - 1].observation);
  });
}

function editHead(head) {
  $("#edit-head").fadeIn();
  $(this).css({ "z-index": 99 });
  $(".overlay").fadeIn(1000);
  const formData = document.querySelector("#form-edit-head");
  formData.addEventListener("submit", (event) => {
    event.preventDefault();
  });
  $.get("/heads", (data) => {
    let heads = data.heads;
    $("#edit-head-span").text(heads[head - 1].name_engine);
    $("#edit-name-head").val(heads[head - 1].name_engine);
    $("#edit-head-fuel").val(heads[head - 1].fuel);
    $("#edit-material-head").val(heads[head - 1].material_kind);
    $("#edit-std-head").val(heads[head - 1].standard_height);
    $("#edit-min-head").val(heads[head - 1].minimum_height);
    $("#edit-obs-head").val(heads[head - 1].observation);
    $("#head-id").val(heads[head - 1].id);
  });
}

function sendData() {
  let id = document.getElementById("head-id").value;
  let editNameHead = document.getElementById("edit-name-head").value;
  let fuel = document.getElementById("edit-head-fuel").value;
  let material = document.getElementById("edit-material-head").value;
  let stdHeight = document.getElementById("edit-std-head").value;
  let minHeight = document.getElementById("edit-min-head").value;
  let observation = document.getElementById("edit-obs-head").value;

  $.ajax({
    url: "/app/edit-head",
    type: "POST",
    data: {
      head_id: id,
      edit_name_head: editNameHead,
      edit_head_fuel: fuel,
      edit_material_head: material,
      edit_std_head: stdHeight,
      edit_min_head: minHeight,
      edit_obs_head: observation,
    },
    success: (res) => {
      $("#message").empty();
      $("#message").append(
        `<span class="message-ok"><b>Cabeçote Atualizado com sucesso!</b></span>`
      );
      $("#message").fadeOut(3000);
      const wait = setTimeout(waitTime, 500);
    },
    error: (error) => {
      alert("SÓ LAMENTO");
    },
  });
}

$(document).on("click", ".btn-del", function (e) {
  e.preventDefault();
  var id = $(this).attr("id");
  var tr = $(this).closest("tr");
  $.ajax({
    url: "/app/delete-head",
    method: "POST",
    data: { id: id },
    success: function (data) {
      tr.fadeOut(1200, function () {
        tr.remove();
      });
    },
  });
});

function closeModal() {
  $(".modal-container").fadeOut();
  $(".overlay").fadeOut(1000);
  $(this).css({ "z-index": 1 });
}

$(document).ready(() => {
  $.get("/heads", (data) => {
    let heads = data.heads;
    let tableHead = $("#table-heads");
    tableHead.empty();
    for (let i = 0; i < heads.length; i++) {
      // console.log(heads[i].name_engine);
      tableHead.append(`<tr>
          <td class="title-car">${heads[i].name_engine}</td>
          <td class="btn-align">
            <button class="btn-info" onclick="openModal('${heads[i].id}')">Info</button>
            <button class="btn-edit" onclick="editHead('${heads[i].id}')">Editar</button>
            <button class="btn-del" onclick="" id="${heads[i].id}">Apagar</button>
          </td>
        </tr>`);
    }
  });

  function loadData() {
    term = document.getElementById("cabecote").value;

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "/app/search-head",
      beforeSend: () => console.log('carregando'),
      data: { search: term },
      success: (data) => {
        let heads = data.heads;
        let tableHead = $("#table-heads");
        tableHead.empty();
        console.log(heads);
        for (let i = 0; i < heads.length; i++) {
           console.log(heads[i].name_engine);
          tableHead.append(`<tr>
          <td class="title-car">${heads[i].name_engine}</td>
          <td class="btn-align">
            <button class="btn-info" onclick="openModal('${heads[i].id}')">Info</button>
            <button class="btn-edit" onclick="editHead('${heads[i].id}')">Editar</button>
            <button class="btn-del" onclick="" id="${heads[i].id}">Apagar</button>
          </td>
        </tr>`);
        }
      },
    });
  }

  $('#cabecote').keyup(() => {
      loadData()
  });

});
