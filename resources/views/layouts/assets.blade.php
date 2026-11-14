<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { theme: { extend: {
  colors: { spruce: '#0f3d3e', amber: '#e3a72f', paper: '#f4f7f6', ink: '#17282a', line: '#dfe7e5' },
  fontFamily: { display: ['"Bricolage Grotesque"', 'sans-serif'], body: ['"Public Sans"', 'sans-serif'] }
}}}
</script>
<style type="text/tailwindcss">
  @layer components {
    .card { @apply bg-white rounded-xl border border-line; }
    .label { @apply block text-sm font-semibold mb-1; }
    .input { @apply w-full rounded-lg border border-line bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-spruce/40 focus:border-spruce; }
    .err { @apply text-rose-600 text-xs mt-1; }
    .btn-primary { @apply inline-flex items-center rounded-lg bg-spruce text-white text-sm font-semibold px-4 py-2 hover:bg-spruce/90 focus-visible:ring-2 focus-visible:ring-amber; }
    .btn-ghost { @apply inline-flex items-center rounded-lg border border-line bg-white text-sm font-semibold px-4 py-2 hover:bg-paper; }
    .badge { @apply inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold; }
  }
</style>
