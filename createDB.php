<?php
    $filename = "articles.json";

    $article = array(
        "id" => "1",
        "title" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit",
        "summary" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla mi urna, consectetur eu dictum a, congue ut neque. Vestibulum vel consectetur mauris. Sed sit amet sem maximus, venenatis ex id, maximus risus. Duis ex ex, vehicula sit amet arcu sit amet, ullamcorper facilisis risus. Nullam ullamcorper mauris in convallis feugiat. Praesent eu diam id ipsum convallis ullamcorper. Maecenas quam dolor, scelerisque sed feugiat feugiat, rutrum ut metus. Vivamus sollicitudin tempus turpis, id vehicula magna auctor id. Sed vel vestibulum risus. <brr> Ut in risus vitae sem suscipit commodo non in purus. Donec blandit porta nisl, tristique vulputate massa tempor eu. Sed eget turpis luctus, mattis justo eu, porta eros. Mauris facilisis mauris hendrerit, vehicula eros eget, fermentum libero. Nulla tincidunt tortor eu lorem dictum, quis efficitur metus tempor. In vestibulum libero a ante eleifend, nec efficitur ante aliquam. Ut imperdiet tortor in nunc gravida, in iaculis lectus aliquam. Sed mollis volutpat.",
        "article" => "<t>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget nisl dolor. Suspendisse molestie et neque sed euismod. Morbi tincidunt felis ac elit iaculis, vitae pulvinar augue suscipit. Aliquam aliquet nisi turpis, ac convallis diam hendrerit a. Suspendisse quis tempor lorem. Donec tristique tempus mi a varius. Ut mollis nisl non felis dapibus, sit amet facilisis urna vulputate.<brt>Donec porttitor dignissim metus, aliquet auctor sem consectetur nec. Pellentesque vel pulvinar quam. In posuere tincidunt imperdiet. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent felis libero, scelerisque at suscipit cursus, scelerisque eget nisl. Donec lobortis volutpat eros in sodales. Curabitur nec metus eget sem vehicula blandit fringilla in neque. Vestibulum ornare sollicitudin lorem sed congue. Praesent consectetur cursus nisl. Curabitur porta mauris tortor, vel mollis ligula gravida ut. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque porttitor pharetra elit, a semper orci mollis eu.<brt>Curabitur venenatis ipsum vel nibh tempor consequat. Curabitur fringilla in nibh eget vulputate. Pellentesque eu faucibus dui. Suspendisse eu pulvinar magna. Quisque mollis, risus vitae mollis pulvinar, ipsum leo volutpat metus, malesuada vehicula enim ipsum sit amet mi. Praesent pellentesque blandit sem varius suscipit. Mauris ornare porttitor dui, ac egestas ante tempor id. Mauris eget accumsan ligula, a consequat ante. Vestibulum rhoncus metus sit amet erat ultricies mattis. Nunc ullamcorper orci sed lacus elementum, vitae dignissim elit tristique.<brt>Nam id mi tellus. Nam non luctus sapien. Vivamus suscipit et est in accumsan. Donec bibendum turpis nec pharetra convallis. Nulla non mi eget ipsum elementum pretium. Integer nec commodo velit. Mauris eu diam nunc. Aenean pretium eros ac orci auctor malesuada. Praesent libero ipsum, lobortis vel tincidunt at, euismod non felis. Cras cursus eleifend turpis sit amet dictum. Fusce dignissim scelerisque pharetra. Quisque dui nisi, volutpat quis lectus scelerisque, vulputate aliquet nibh. Quisque consectetur interdum arcu sit amet iaculis.<brt>Nulla quis erat accumsan, commodo odio a, finibus enim. Morbi pharetra ipsum neque, ac consectetur tellus viverra at. Praesent suscipit hendrerit nulla, vel aliquam nisi congue eget. Aliquam dapibus suscipit mi, et efficitur ex tempus sed. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc fringilla tellus massa, id posuere nulla molestie vitae. Sed sodales libero vitae metus cursus, ac vehicula est accumsan.",
        "url" => "article.php?id=1",
        "image" => "uploads/1/Flag_of_the_Roman_Empire.png",
        "image_description" => "Flag of the Roman Empire.",
        "category" => "test",
        "timestamp_created" => time(),
        "authorId" => "1"
    );

    $articles = array(
        "articles" => array($article)
    );
    
    $encodedData = json_encode($articles);
    
    var_dump($encodedData);

    file_put_contents($filename, $encodedData);
?>