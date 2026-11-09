import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import GridMotion from './GridMotion';

const inventoryImages = [
  'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1553413077-190dd305871c?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1616401784845-180882ba9ba8?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1587293852726-70cdb56c2866?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1565793298595-6a879b1d9492?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1617347454431-f49d7ff5c3b1?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1580674684081-7617fbf3d745?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1542838132-92c53300491e?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1566576912321-d58ddd7a6088?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1705032033999-efa3082e1a4e?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1530587191325-3db32d826c18?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1590247813693-5541d1c609fd?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1586528116493-a029325540fa?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1595246140625-573b715d11dc?w=640&q=80&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=640&q=80&auto=format&fit=crop'
];

function GridMotionContainer() {
  const [theme, setTheme] = useState(() => {
    return localStorage.getItem('app-theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light');
  });

  useEffect(() => {
    const handleThemeChange = (e) => {
      if (e.detail && e.detail.theme) {
        setTheme(e.detail.theme);
      }
    };
    window.addEventListener('app-theme-changed', handleThemeChange);
    return () => {
      window.removeEventListener('app-theme-changed', handleThemeChange);
    };
  }, []);

  return (
    <div style={{ position: 'relative', width: '100%', height: '100%' }}>
      <GridMotion
        items={inventoryImages}
        rows={4}
        aspectRatio={1.33}
        gap={16}
        radius={14}
        angle={-12}
        tilt={0}
        speed={24}
        direction="alternate"
        parallax={0.5}
        spotlight={0.6}
        dim={theme === 'dark' ? 0.28 : 0.38}
        fade={0.5}
        theme={theme}
        grayscale={false}
      />
    </div>
  );
}

let rootInstance = null;

export function mountGridMotion() {
  const container = document.getElementById('grid-motion-root');
  if (!container) return;

  if (container.dataset.mounted === 'true') return;
  container.dataset.mounted = 'true';

  if (!rootInstance) {
    rootInstance = createRoot(container);
  }

  rootInstance.render(<GridMotionContainer />);
}
