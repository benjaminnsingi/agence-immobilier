window.onload = () => {
    // "Delete" button management
    let links = document.querySelectorAll("[data-delete]");

    // We loop on links
    for (link of links) {

        link.addEventListener("click", function (e) {

            // We prevent navigation
            e.preventDefault();

            // Confirmation is requested
            if (confirm("Voulez-vous supprimer cette image ?")) {
            // We send an Ajax request to the href of the link with the DELETE method

                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // We get the response in JSON format
                    response => response.json()
                ).then(data => {
                    if (data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        });
    }
}