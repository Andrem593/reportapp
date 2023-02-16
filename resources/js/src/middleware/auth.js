export default function auth({ next, router }) {
    if (!localStorage.getItem('userInfo')) {
      return router.push({ name: 'login' });
    }
  
    return next();
  }