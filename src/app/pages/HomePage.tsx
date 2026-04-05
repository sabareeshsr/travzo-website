import { Hero } from '../components/Hero';
import { OurPackages } from '../components/OurPackages';
import { Stats } from '../components/Stats';
import { TrendingTours } from '../components/TrendingTours';
import { WhyChooseUs } from '../components/WhyChooseUs';
import { Testimonials } from '../components/Testimonials';
import { ContactForm } from '../components/ContactForm';
import { LatestBlog } from '../components/LatestBlog';
import { Newsletter } from '../components/Newsletter';

export default function HomePage() {
  return (
    <>
      <Hero />
      <OurPackages />
      <Stats />
      <TrendingTours />
      <WhyChooseUs />
      <Testimonials />
      <ContactForm />
      <LatestBlog />
      <Newsletter />
    </>
  );
}
