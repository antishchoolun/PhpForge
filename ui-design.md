# PhpForge UI Design Documentation

## Design System

### Colors
```css
--primary: #6366f1      /* Indigo */
--primary-dark: #4f46e5 /* Darker Indigo */
--secondary: #ec4899    /* Pink */
--dark: #1e293b        /* Slate */
--light: #f8fafc       /* Light Gray */
--success: #10b981     /* Green */
--warning: #f59e0b     /* Orange */
--danger: #ef4444      /* Red */
--gray: #64748b        /* Gray */
```

### Typography
- Font Family: 'Satoshi', system fonts
- Font Weights: 300 (light), 400 (regular), 500 (medium), 600 (semibold), 700 (bold), 900 (black)

## Components

### 1. Modal System
- Full-screen, split-layout design
- Dark mode support
- Backdrop blur effect
- Smooth transitions
- Z-index management
- Custom scrollbars
- Responsive layout

### 2. Code Actions Component
```html
<x-code-actions 
    target-id="code-element-id"
    download-name="filename"
    download-ext=".php"
    position="top-right"
/>
```
Features:
- Copy to clipboard
- File download
- Visual feedback
- Tooltips
- Position customization
- Dark mode support

### 3. Quantum Loader
```html
<x-quantum-loader
    message="Custom loading message"
    :show-particles="true"
/>
```
Features:
- Animated particles
- Progress counter
- Multiple spinning rings
- Customizable message
- Backdrop blur
- Dark mode support

### 4. Error Popup System
```html
<x-error-popup
    type="error|warning|info"
    title="Error Title"
    message="Error message"
    :details="['Detail 1', 'Detail 2']"
    action="Action Button"
    action-url="/action-url"
/>
```
Features:
- Multiple error types
- Slide-up animation
- Action buttons
- Backdrop blur
- Z-index priority
- Dark mode support

### 5. Usage Counter
```html
<x-usage-counter 
    :count="currentCount"
    :limit="5"
/>
```
Features:
- Visual progress indicator
- Color-coded states
- Limit warnings
- Responsive design

## Animations

### Transitions
```css
/* Modal transition */
.modal {
    transition: opacity 0.3s ease;
}

/* Content scale */
.modal-content {
    transition: transform 0.3s ease;
}

/* Slide up */
.error-popup {
    transition: transform 0.3s ease;
}
```

### Loading States
- Quantum particle system
- Multiple spinning rings
- Progress counter animation
- Pulsing quantum bits

### Feedback Animations
- Success state transitions
- Copy button feedback
- Download button feedback
- Error popup slide-up

## Dark Mode

### Implementation
- System preference detection
- Manual toggle option
- Persistent preference storage
- Smooth transition between modes

### Color Palette (Dark)
```css
--dark-bg: #1e1e2e
--dark-surface: #313244
--dark-border: #45475a
--dark-text: #cdd6f4
--dark-muted: #6c7086
```

## Responsive Design

### Breakpoints
```css
sm: 640px   /* Small devices */
md: 768px   /* Medium devices */
lg: 1024px  /* Large devices */
xl: 1280px  /* Extra large devices */
2xl: 1536px /* 2X large devices */
```

### Layout Adjustments
- Modal full-screen on mobile
- Stack split views on small screens
- Adjust padding and margins
- Scale down typography
- Reorganize navigation

## Accessibility

### Features
- ARIA labels
- Keyboard navigation
- Focus management
- Screen reader support
- Color contrast compliance
- Reduced motion support

## Performance

### Optimizations
- Lazy loaded components
- Deferred animations
- Efficient transitions
- Image optimization
- Font loading strategy
- CSS purging
