<style>
    /* HTML: <div class="loader"></div> */
.loader {
  width: 40px;
  aspect-ratio: 1;
  --c: linear-gradient(#000 0 0);
  --r1: radial-gradient(farthest-side at bottom,#000 93%,#0000);
  --r2: radial-gradient(farthest-side at top   ,#000 93%,#0000);
  background:
    var(--c) ,var(--r1),var(--r2),
    var(--c) ,var(--r1),var(--r2),
    var(--c) ,var(--r1),var(--r2);
  background-repeat: no-repeat;
  animation: l2 1s infinite alternate;
}
@keyframes l2 {
  0%,25% {
    background-size: 8px 0,8px 4px,8px 4px,8px 0,8px 4px,8px 4px,8px 0,8px 4px,8px 4px;
    background-position: 0 50%,0 calc(50% - 2px),0 calc(50% + 2px),50% 50%,50% calc(50% - 2px),50% calc(50% + 2px),100% 50%,100% calc(50% - 2px),100% calc(50% + 2px);
 }
 50% {
    background-size: 8px 100%,8px 4px,8px 4px,8px 0,8px 4px,8px 4px,8px 0,8px 4px,8px 4px;
    background-position: 0 50%,0 calc(0% - 2px),0 calc(100% + 2px),50% 50%,50% calc(50% - 2px),50% calc(50% + 2px),100% 50%,100% calc(50% - 2px),100% calc(50% + 2px);
 }
 75% {
    background-size: 8px 100%,8px 4px,8px 4px,8px 100%,8px 4px,8px 4px,8px 0,8px 4px,8px 4px;
    background-position: 0 50%,0 calc(0% - 2px),0 calc(100% + 2px),50% 50%,50% calc(0% - 2px),50% calc(100% + 2px),100% 50%,100% calc(50% - 2px),100% calc(50% + 2px);
 }
 95%,100% {
    background-size: 8px 100%,8px 4px, 8px 4px,8px 100%,8px 4px,8px 4px,8px 100%,8px 4px,8px 4px;
    background-position: 0 50%,0 calc(0% - 2px),0 calc(100% + 2px),50% 50%,50% calc(0% - 2px),50% calc(100% + 2px),100% 50%,100% calc(0% - 2px),100% calc(100% + 2px);
 }
}
</style>

<div class="w-full h-full flex items-center justify-center absolute top-0 left-0" id="Loading">
    <div class="layer bg-black bg-opacity-20 w-full h-full absolute top-0 left-0"></div>
    <div class="loader"></div>
</div>
