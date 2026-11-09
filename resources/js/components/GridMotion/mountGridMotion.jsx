import React from 'react';
import { createRoot } from 'react-dom/client';
import GridMotion from './GridMotion';

const defaultItems = [
  'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=640&q=75&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1705032033999-efa3082e1a4e?w=640&q=75&auto=format&fit=crop',
  '📦 Manajemen Stok Modern',
  <div key="tag-ai" className="px-3 py-2 font-bold text-xs text-purple-800 bg-purple-100/90 rounded-xl shadow-xs">✨ AI Stock Generator</div>,
  'https://images.unsplash.com/photo-1553413077-190dd305871c?w=640&q=75&auto=format&fit=crop',
  '⚡ Pelacakan Inventaris Real-Time',
  <div key="tag-excel" className="px-3 py-2 font-bold text-xs text-emerald-800 bg-emerald-100/90 rounded-xl shadow-xs">📊 Import/Export Excel</div>,
  'https://images.unsplash.com/photo-1721407964262-f9864b562453?w=640&q=75&auto=format&fit=crop',
  '🔒 Keamanan & Akurasi Gudang',
  <div key="tag-delcom" className="px-3 py-2 font-bold text-xs text-blue-800 bg-blue-100/90 rounded-xl shadow-xs">🚀 100/100 Performa Teruji</div>
];

let rootInstance = null;

export function mountGridMotion() {
  const container = document.getElementById('grid-motion-root');
  if (!container) return;

  if (container.dataset.mounted === 'true') return;
  container.dataset.mounted = 'true';

  if (!rootInstance) {
    rootInstance = createRoot(container);
  }

  rootInstance.render(
    <div style={{ position: 'relative', width: '100%', height: '100%' }}>
      <GridMotion
        items={defaultItems}
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
        dim={0.35}
        fade={0.5}
        theme="light"
        grayscale={false}
      />
    </div>
  );
}
