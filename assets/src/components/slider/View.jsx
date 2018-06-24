import PropTypes from 'prop-types';

const View = ({
  image,
  title,
  body = null,
  url = null,
  urlLabel = null,
}) => <div>
  <div className="gw-slider-slide-image-container">
    <div className="gw-slider-slide-image" style={{ backgroundImage: `url("${image}")` }}/>
  </div>
  <div className="gw-slider-slide-content">
    <h3 className="gw-slider-slide-title">{title}</h3>
    {body !== null && <div className="gw-slider-slide-body">{body}</div>}

    {url !== null && <a href={url} className="gw-btn gw-btn-pill gw-slider-slide-button">
      {urlLabel || 'Go to page'}
    </a>}
  </div>
</div>;

View.propTypes = {
  image: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  body: PropTypes.string,
  url: PropTypes.string,
  urlLabel: PropTypes.string,
};

export default View;
