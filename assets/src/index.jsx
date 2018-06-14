// import 'babel-polyfill'; // polyfill for all ES2015+ features, must be imported in root file

import { render } from 'react-dom';

import Slider from './components/Slider';

// Setup slider, if a container exists.
// A page can only contain ONE slider at a time (alteast for now)
const sliderContainer = document.getElementById('gwSlider');

if (sliderContainer) {
  if (!window.gcSliderData) {
    console.error('[GrooaWidgets] Slider requires global variable `gcSliderData`');
  } else {
    render(<Slider views={window.gcSliderData}/>, sliderContainer);
  }
}
