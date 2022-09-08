import { Controller } from "@hotwired/stimulus";
import axios from "axios";
export default class extends Controller {
  static values = {
    songUrl: String,
  };
  async play(e) {
    e.preventDefault();
    const res = await axios.get(this.songUrlValue);
    if (res) {
      const audio = new Audio(res.data.url);
      audio.play();
    } else {
      console.error("Someting went wrong");
    }
  }
}
