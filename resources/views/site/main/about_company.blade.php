@extends('site.layouts.default')

@section('content')
  <main class="main page-decor-holder ">
    <img class="decor decor_8" src="/images/decor/img_10.png" data-parallax='{"y": -60, "smoothness": 30}' />
    <img class="decor decor_9" src="/images/decor/img_12.png" data-parallax='{"y": -100, "smoothness": 15}' />
    <img class="decor decor_10" src="/images/decor/img_2.png" data-parallax='{"y": -140, "smoothness": 45}' />
    <img class="decor decor_11" src="/images/decor/img_8.png" data-parallax='{"y": -60, "smoothness": 30}' />
    <img class="decor decor_12" src="/images/decor/img_13.png" data-parallax='{"y": -100, "smoothness": 15}' />
    <section class="indent-block">
      <div class="container">
        <h1 class="text-center">UK Property Advisors</h1>
        <div class="about-info">
          <div class="info-item">
            <div class="img-box">
              <img src="/images/content/img_36.jpg" alt="">
            </div>
            <div class="text-box">
              <p>UK Property Advisors Ltd is an independent property buying agent. We focus on providing practical
                solutions to international clients who consider to invest into London properties. We are entirely
                privately owned and are led by Nataliya Makhon- ina-Byrdan who is fully involved in our activities on a
                day-to-day and strategic basis. We represent Buyers and Investors exclusively in all property
                transactions and strive for getting best deals for our clients.</p>
              <div class="percent-box">
                <p>The average discount from the initial asking price achieved in Q4 2017 was</p>
                <span class="percent">7.18%</span>
              </div>
            </div>
          </div>
          <div class="info-item">
            <div class="img-box">
              <img src="/images/content/img_37.jpg" alt="">
            </div>
            <div class="text-box">
              <p>This is what fundamentally distinguish us from high-street real-estate agents that are hired by Sellers
                to maximize profit from home sales. Since 2010 Nataliya is investing into London property market. She
                got her expertise thorough analysis of historical and current market data and fulfilment of different
                investment strategies. Throughout the years she cooperated with various local property experts and
                gained an invaluable practical experience alongside with UK legislation knowledge.</p>
              <p>We utilise the most up-to-date data and analytical reports available on the London and UK housing
                market that is also used by Bloomberg, Financial Times, Nationwide Building Society and major UK
                mortgage providers and international banks. UK Property Advisors is a member of the UK Property Redress
                and Tenancy Deposit Schemes</p>
            </div>
          </div>
          <div class="info-item">
            <div class="img-box">
              <img src="/images/content/img_38.jpg" alt="">
            </div>
            <div class="text-box">
              <blockquote class="blockquote">
                <p>When considering a specific property investment opportunity it is critical to understand fair and
                  worst case property valuation when the market will change, transactional risks and possible pitfalls,
                  structure of the deal, taxation, legal and other associated costs, the basis for future increase in
                  the property value, upcoming changes in UK legislation and step-by-step buying process.</p>
                <cite>As Nataliya says</cite>
              </blockquote>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="indent-block certificate-area">
      <div class="container tab-holder">
        <div class="custom-row">
          <div class="description-box tab-content">
            <div class="tab-item tab-item-tab_1 active">
              <h3>Nataliya’s personal certificates</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="tab-item tab-item-tab_2">
              <h3>PRS Certificate. TDS Certificate</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                deserunt mollit anim id est laborum. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui
                officia deserunt mollit anim id est laborum.</p>
            </div>
            <ul class="tab-navigation-list">
              <li class="active" data-class="tab_1"><a href="#">Nataliya’s personal certificates</a></li>
              <li data-class="tab_2"><a href="#">PRS Certificate. TDS Certificate</a></li>
            </ul>
          </div>
          <div class="slider-holder tab-content">
            <div class="tab-item tab-item-tab_1 active">
              <div class="certificate-slider simple-slider">
                <div><img src="/images/content/img_32.jpg" /></div>
                <div><img src="images/content/img_33.jpg" /></div>
                <div><img src="images/content/img_34.jpg" /></div>
              </div>
            </div>
            <div class="tab-item tab-item-tab_2">
              <div class="certificate-slider simple-slider">
                <div><img src="/images/content/img_34.jpg" /></div>
                <div><img src="/images/content/img_35.jpg" /></div>
                <div><img src="/images/content/img_32.jpg" /></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="subscribe-section" style="background-image: url('/images/banners/img_2.jpg')">
      <div class="container">
        <div class="row text-center">
          <div class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <div class="section-title">Contact Us For Free Initial Consultation</div>
            <p>We utilise the most up-to-date data and analytical reports available on the London and UK housing market
              that is also used by Bloomberg, Financial Times, Nationwide Building Society and major UK mortgage
              providers and international banks. </p>
            <a href="#" class="link" data-toggle="modal" data-target=".consultation-modal">contact an agent</a>
          </div>
        </div>
      </div>
    </section>
    <section class="indent-block testimonials-section" style="background-image: url('/images/banners/img_10.jpg')">
      <div class="container large">
        <h3>Testimonials</h3>
        <div class="testimonials-slider">
          <div>
            <div class="inner-box">
              <span class="user-name">An Estate Agent</span>
              <span class="location">South London</span>
              <p>Sed ut perspiciatis, unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                totam rem aperiam eaque ipsa, quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                sunt, explicabo.</p>
            </div>
          </div>
          <div>
            <div class="inner-box">
              <span class="user-name">An Investor</span>
              <span class="location">Russia</span>
              <p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et
                voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente
                delectus. Et harum quidem rerum facilis est et expedita distinctio. Itaque earum rerum hic tenetur a
                sapiente delectus. Et harum quidem rerum facilis est et expedita distinctio.</p>
            </div>
          </div>
          <div>
            <div class="inner-box">
              <span class="user-name">A Buyer</span>
              <span class="location">UAE</span>
              <p> At vero eos et accusamus et iusto odio dignissimos ducimus, qui blanditiis praesentium voluptatum
                deleniti atque corrupti, quos dolores et quas molestias excepturi sint, obcaecati cupiditate non
                provident, similique sunt in culpa, qui officia deserunt mollitia animi, id est laborum et dolorum
                fuga. </p>
            </div>
          </div>
          <div>
            <div class="inner-box">
              <span class="user-name">An Investor</span>
              <span class="location">Russia</span>
              <p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et
                voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente
                delectus. Et harum quidem rerum facilis est et expedita distinctio. Itaque earum rerum hic tenetur a
                sapiente delectus. Et harum quidem rerum facilis est et expedita distinctio.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection