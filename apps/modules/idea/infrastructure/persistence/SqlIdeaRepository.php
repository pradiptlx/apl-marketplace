<?php 

namespace Idy\Idea\Infrastructure\Persistence;

use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\Rating;
use Idy\Idea\Domain\Repository\IdeaRepository;
use PDO;
use Phalcon\Db\Adapter\Pdo\Mysql;

class SqlIdeaRepository implements IdeaRepository
{
    private $db;

    public function __construct(Mysql $db)
    {
        $this->db = $db;
    }

    public function byId(IdeaId $id)
    {
        $statement = sprintf("SELECT * FROM ideas WHERE ideas.id = :idea_id");
        $param = ['idea_id' => $id->id()];

        return $this->db->query($statement, $param)
            ->fetch(PDO::FETCH_ASSOC);
    }

    public function save(Idea $idea)
    {
        $statement = sprintf("INSERT INTO ideas(id, title, description, author_name, author_email, votes) VALUES(:id, :title, :description, :author_name, :author_email, :votes)" );
        $params = ['id' => $idea->id()->id() , 'title' => $idea->title(), 'description' => $idea->description(), 'author_name' => $idea->author()->name(), 'author_email' => $idea->author()->email(), 'votes' => 0];

        return $this->db->execute($statement, $params);
    }

    public function allIdeas()
    {
        $statement = sprintf("SELECT * FROM ideas");

        return $this->db->query($statement)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function allRatings()
    {
        $statement = sprintf("SELECT * FROM ratings");

        return $this->db->query($statement)
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vote(Idea $idea)
    {
        $statement = sprintf("UPDATE ideas SET ideas.votes = :votes WHERE ideas.id = :idea_id");
        $params = ['votes' => $idea->votes(), 'idea_id' => $idea->id()->id()];

        return $this->db->execute($statement, $params);
    }

    public function rate(IdeaId $id, Rating $rating)
    {
        $statement = sprintf("INSERT INTO ratings(idea_id, value, name) VALUES(:idea_id, :value, :name)");
        $params = ['idea_id' => $id->id(), 'value' => $rating->value(), 'name' => $rating->user()];

        return $this->db->execute($statement, $params);
    }

    public function getRatingsByIdeaId(IdeaId $id)
    {
        $statement = sprintf("SELECT * FROM ratings WHERE idea_id = :idea_id");
        $param = ['idea_id' => $id->id()];

        return $this->db->query($statement, $param)
            ->fetchAll(PDO::FETCH_ASSOC);
    }
}