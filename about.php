
<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            body {
                font: 24px Helvetica;
                background: #999999;
            }

            .bioPhoto {
                max-width: 220px;   
            }

            img {
                max-width: 200px;
                border-radius: 200pt;
                float: left;
                margin-right: 20px;
                margin-bottom: 20px;
            }
            
            .person {
                min-height:200px;
            }
            #main {
                min-height: 800px;
                margin: 0px;
                padding: 0px;
                display: -webkit-flex;
                display:         flex;
                -webkit-flex-flow: row;
                flex-flow: row;
            }

            #articleContainer {
                min-height: 800px;
                margin: 0px;
                padding: 0px;
                display: -webkit-flex;
                display:         flex;
                -webkit-flex-flow: column;
                flex-flow: column; 
                -webkit-flex: 3 1 60%;
                flex: 3 1 60%;
                -webkit-order: 2;
                order: 2;
            }

            #articleContainer > article {
                margin: 4px;
                padding: 5px;
                border: 1px solid #cccc33;
                border-radius: 7pt;
                background: #dddd88;
                -webkit-flex: 3 1 50%;
                flex: 3 1 50%;/*
                -webkit-order: 2;
                order: 2;*/
            }

            #main > nav {
                margin: 4px;
                padding: 5px;
                border: 1px solid #8888bb;
                border-radius: 7pt;
                background: #ccccff;
                -webkit-flex: 1 6 20%;
                flex: 1 6 20%;
                -webkit-order: 1;
                order: 1;
            }

            #main > aside {
                margin: 4px;
                padding: 5px;
                border: 1px solid #8888bb;
                border-radius: 7pt;
                background: #ccccff;
                -webkit-flex: 1 6 20%;
                flex: 1 6 20%;
                -webkit-order: 3;
                order: 3;
            }

            header, footer {
                display: block;
                margin: 4px;
                padding: 5px;
                min-height: 100px;
                border: 1px solid #eebb55;
                border-radius: 7pt;
                background: #ffeebb;
            }

            /* Too narrow to support three columns */
            @media all and (max-width: 640px) {

                #main, #page {
                    -webkit-flex-flow: column;
                    flex-direction: column;
                }
                /*   COMMENT THIS OUT
                   #main > article, #main > nav, #main > aside {
                     Return them to document order 
                    -webkit-order: 0;
                            order: 0;
                   }*/

                #main > header{
                    -webkit-order: 0;
                    order: 0;    
                }
                #main > nav{
                    -webkit-order: 1;
                    order: 1;
                }

                #main > article{
                    -webkit-order: 2;
                    order: 2;
                }

                #main > footer{
                    -webkit-order: 10;
                    order: 10;
                }
                #main > nav, #main > aside, header, footer {
                    min-height: 50px;
                    max-height: 50px;
                }

            }

        </style>
    </head>
    <!--
    ####################### CODE BEGINS HERE #######################-->
    <body>
        <header>
            <h1>Chekkit</h1>
            <h2>Now with real teachers and course names!</h2>

        </header>
        <div id='main'>
            <?php include "nav2.php" ?>
            <div id='articleContainer'>
                <article id="Project">
                    <h3>About the Project</h3>
                    <p>With so much to do and limited time to do it all, we wanted
                        to help students find fun and exciting activities amid their
                        busy schedule.</p>
                    <p>Our solution to provide the reddit of activities for college
                        students in the Burlington area.</p>
                </article>
                <article id="People">
                    <h3>The coders</h3>
                    <div class="person">
                        <figure class="bioPhoto">
                            <img alt="Joe" src="../images/Joe.png">
                        </figure>

                        <p> Joe the project manager, likes getting it done. He
                                is patient and hardworking, making a great leader as well
                                as a good friend.
                        </p>
                    </div>
                    <div class="person">
                        <figure class="bioPhoto">
                            <img alt="Alan" src="../images/AlanChew.png">
                        </figure>
                        <p>
                            Every batman has a robin. Alan can sometimes be a wildcard
                            but that makes the journey ever more interesting. When
                            his passion align with his vision, he can be a formable
                            sidekick and coding fiend. 
                        </p>
                    </div>
                </article>
            </div>

            <aside>YOUR AD HERE!!</aside>
        </div>
        <footer>Web site designed by Alan Chu and Joe Siebert</footer>
    </body>
</html>
