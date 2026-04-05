import { Outlet } from 'react-router';
import { EnhancedHeader } from '../components/EnhancedHeader';
import { Footer } from '../components/Footer';
import { ScrollToTop } from '../components/ScrollToTop';

export function RootLayout() {
  return (
    <div className="min-h-screen">
      <ScrollToTop />
      <EnhancedHeader />
      <main>
        <Outlet />
      </main>
      <Footer />
    </div>
  );
}