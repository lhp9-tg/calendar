console.log("Hello World!")

const modal = document.querySelector(".modal")
const trigger = document.querySelectorAll(".items")
const closeButton = document.querySelector(".close-button")

console.log(trigger)

function toggleModal() {
modal.classList.toggle("show-modal")
}

function windowOnClick(event) {
    if (event.target === modal) {
        toggleModal()
    }
}

trigger.forEach(element => {
    element.addEventListener("click", toggleModal)
});

closeButton.addEventListener("click", toggleModal)
window.addEventListener("click", windowOnClick)