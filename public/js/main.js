
// DELETE CONFIRMATION  MODAL CUSTOMIZING...

let deleteConfirmation = function (e) {
    if (typeof swal !== "undefined") {
        swal({
            title: "Suppression",
            text: "Cet élément sera supprimé",
            dangerMode: true,
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: "Oui, Supprimer",
            },
            cancel: true,
        }).then((value) => {
            if (value) {
                e.submit();
            } else {
                swal("Suppression annulée", {
                    timer: 2000,
                });
            }
        });
    } else {
        value = confirm("Voulez vous supprimer cet élément ?");
        if (value) {
            e.submit();
        }
    }
    // e.submit();
};
