
        </div>
            <script type="text/javascript">    
                //菜单下拉展开
                var mainMenu = document.getElementById("main-menu");
                var lis = mainMenu.getElementsByTagName("li");
                for(var i=0,j=lis.length;i<j;i++){
                    var li = lis[i];
                    li.onmouseenter=function(){
                        var enterLi = this;
                        var ul = enterLi.children[1];
                        if(!ul) return;
                        ul.style.opacity = 0.5;
                        var tick = setInterval(function(){
                            var opacity = parseFloat(ul.style.opacity);//这个函数是把字符串变成数字（浮点数）
                            opacity += 0.07;
                            if(opacity>=1){
                              opacity=1;  
                              clearInterval(tick);
                            } 
                            ul.style.opacity =opacity;
                        },100);
                    };
                }           
            
            </script>
        </div>
            <div id="footer">
                <div id="quick-access"></div>
                <div id="copyright">
                    <p>Amber@qq.com All right reserved.</p>
                </div>
            </div>
        </div>


 
    </body>

</html>