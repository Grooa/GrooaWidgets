import { render } from 'enzyme';
import View from '../View';

describe('<View />', () => {
  let sliderView;

  beforeEach(() => {
    sliderView = {
      image: 'http://test.com/test.jpg',
      url: '/testTest',
      urlLabel: 'Go to Test',
      title: 'Hello world',
      body: 'Lorem lipsum dolor sit amed',
    };
  });

  it('should render properly', () => {
    const wrapper = render(<View {...sliderView} />);

    expect(wrapper).toMatchSnapshot();
  });
});
