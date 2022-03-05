import $ from "jquery";
class Search {
  //1. kuvailee ja luo/toteuttaa objektin, so basically our DNA
  constructor() {
    this.addSearchHTML();
    this.resultsDiv = $("#search-overlay__results");
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
  }

  //2. eventit
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keyPressMagical.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  //. metodit (function, action, verbit etc)
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);
      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"> </div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 550);
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.getJSON(
      lowkiloData.root_url +
        "/wp-json/lowkilo/v1/search?term=" +
        this.searchField.val(),
      (results) => {
        this.resultsDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length
                ? '<ul class="link-list min-list">'
                : "<p>No general information matches that search.</p>"
            }
              ${results.generalInfo
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a> ${
                      item.postType == "post" ? `by ${item.authorName}` : ""
                    }</li>`
                )
                .join("")}
            ${results.generalInfo.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Products</h2>
            ${
              results.products.length
                ? '<ul class="product-cards">'
                : `<p>No products match that search. <a href="${lowkiloData.root_url}/products">View all products</a></p>`
            }
              ${results.products
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a></li>`
                )
                .join("")}${results.products.length ? "</ul>" : ""}

            <h2 class="search-overlay__section-title">Personnel</h2>
            ${
              results.personnels.length
                ? '<ul class="link-list min-list">'
                : `<p>No personnel matched that search. <a href="${lowkiloData.root_url}/personnel">View Our superstars</a></p>`
            }
              ${results.personnels
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a></li>`
                )
                .join("")}${results.personnels.length ? "</ul>" : ""}

          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Events</h2>
            ${
              results.events.length
                ? ""
                : `<p> No events, no life <a href="${lowkiloData.root_url}/events">View all Events</a></p>`
            }
              ${results.events
                .map(
                  (item) =>
                    `
                    <div class="event-summary">
            <a class="event-summary__date t-center" href="${item.permalink}">
              <span class="event-summary__month">${item.month}</span>
              <span class="event-summary__day">${item.day}</span>
            </a>
            <div class="event-summary__content">
              <h5 class="event-summary__title headline headline--tiny">
                <a href="$item.permalink"></a>
              </h5>
              <p>${item.description}
                <a href="${item.permalink}" class="nu gray">Learn more</a>
              </p>
            </div>
          </div>
                    `
                )
                .join("")}
            ${results.events.length ? "</ul>" : ""}
          </div>
        </div>
      `);
        this.isSpinnerVisible = false;
      }
    );
  }

  keyPressMagical(e) {
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$("input,textarea").is(":focus")
    ) {
      this.openOverlay();
    }
    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val("");
    setTimeout(() => this.searchField.focus(), 301);
    console.log("tää avautui hei!");
    this.isOverlayOpen = true;
    return false;
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    console.log("tää sulkeutui hei!");
    this.isOverlayOpen = false;
  }
  addSearchHTML() {
    $("body").append(`
  <div class="search-overlay">
  <div class="search-overlay__top">
  <div class="container">
    <i class="fa fa-search search-overlay__icon"aria-hidden="true"></i>
    <input type="text"class="search-term" autocomplete="off" placeholder="What do you wish to find?" id="search-term">
    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>    
    </div> 
    </div>
  <div class="container">
    <div id="search-overlay__results"></div>
      </div>
  </div>
  `);
  }
}

export default Search;
