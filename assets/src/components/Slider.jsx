import React from 'react';
import PropTypes from 'prop-types';

import SlickSlider from 'react-slick';

import View from './slider/View';

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

  render() {
    return <div className="gw-slider">
      <SlickSlider {...this.settings}>
        {this.props.views.map((view, index) => <View
          key={`slide-${index}`}
          title={view.title}
          image={view.img}
          body={view.body}
          url={view.url}
          urlLabel={view.urlLabel} />)}
      </SlickSlider>
    </div>;
  }
}

Slider.propTypes = {
  views: PropTypes.array.isRequired,
};
