import { createBrowserRouter } from 'react-router';
import { RootLayout } from './layouts/RootLayout';
import HomePage from './pages/HomePage';
import AboutPage from './pages/AboutPage';
import ContactPage from './pages/ContactPage';
import PackageListPage from './pages/PackageListPage';
import PackageDetailPage from './pages/PackageDetailPage';
import BlogListPage from './pages/BlogListPage';
import BlogDetailPage from './pages/BlogDetailPage';

export const router = createBrowserRouter([
  {
    path: '/',
    Component: RootLayout,
    children: [
      {
        index: true,
        Component: HomePage,
      },
      {
        path: 'about',
        Component: AboutPage,
      },
      {
        path: 'contact',
        Component: ContactPage,
      },
      {
        path: 'packages/:category',
        Component: PackageListPage,
      },
      {
        path: 'package/:id',
        Component: PackageDetailPage,
      },
      {
        path: 'blog',
        Component: BlogListPage,
      },
      {
        path: 'blog/:id',
        Component: BlogDetailPage,
      },
    ],
  },
]);