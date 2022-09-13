import { Controller } from "@hotwired/stimulus";
import axios from "axios";
export default class extends Controller {
  static values = {
    songUrl: String,
  };
  initialize() {
    this.element.audio = new Audio();
  }

  async play(e) {
    e.preventDefault();
    //Current song playing ?
    if (this.element.audio.src === this.songUrlValue) {
      return;
    } //Cannot finish got to apply the controller to the parent to keep track if the audio is playing
    //Anything else playing ?
    if (!this.element.audio.paused) {
      console.log("Something was playing");
      this.element.audio.pause();
    }
    const res = await axios.get(this.songUrlValue);

    if (res) {
      this.element.audio = new Audio(res.data.url);
      console.log(this.element.audio);
      this.element.audio.play();
    } else {
      console.error("Someting went wrong");
    }
  }
}
