import React from 'react';
import PropTypes from 'prop-types';

import SlickSlider from 'react-slick';

export default class Slider extends React.Component {
  constructor() {
    super();

    this.settings = {
      dots: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1,
    };
  }

  // eslint-disable-next-line class-methods-use-this
  render() {
    return <div className="gw-slider">
      <SlickSlider {...this.settings}>
        {this.props.views.map((view, index) => <div key={`slide-${index}`}>
          <div className="gw-slider-slide-image-container">
            <div className="gw-slider-slide-image" style={{ backgroundImage: `url("${view.img}")` }}/>
          </div>

          <div className="gw-slider-slide-content">
            <h3 className="gw-slider-slide-title">{view.title}</h3>
            {!!view.body && <div className="gw-slider-slide-body">{view.body}</div>}

            {!!view.url && <a href={view.url} className="gw-btn gw-btn-pill gw-slider-slide-button">
              {view.urlLabel || 'Go to page'}
            </a>}
          </div>
        </div>)}
      </SlickSlider>
    </div>;
  }
}

Slider.propTypes = {
  views: PropTypes.array.isRequired,
};
