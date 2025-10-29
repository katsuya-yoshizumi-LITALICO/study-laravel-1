import { useEffect, useState } from 'react';
import { Textarea } from '@/components/ui/textarea';
import { Input } from '@/components/ui/input';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { useForm } from 'react-hook-form';

type Post = {
  id: number;
  title: string;
  body: string;
  created_at: string;
};

const API_URL = 'http://localhost:8000/api/posts';

function App() {
  const {
    register,
    handleSubmit,
    reset,
    formState: { errors },
  } = useForm<{ title: string; body: string }>();
  const [posts, setPosts] = useState<Post[]>([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchPosts();
  }, []);

  const fetchPosts = async () => {
    setLoading(true);
    const res = await fetch(API_URL);
    const data = await res.json();
    setPosts(data);
    setLoading(false);
  };

  const onSubmit = async (data: { title: string; body: string }) => {
    await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    reset();
    fetchPosts();
  };

  return (
    <div className="p-4">
      <h1 className="text-2xl font-bold mb-4">掲示板SPA</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="mb-6">
        <Input
          type="text"
          placeholder="タイトル"
          {...register('title', { required: 'タイトルは必須です' })}
        />
        {errors.title && (
          <p className="text-red-500 text-sm">{errors.title.message}</p>
        )}
        <Textarea
          placeholder="本文"
          {...register('body', { required: '本文は必須です' })}
          rows={5}
          className="min-h-[160px]"
        />
        {errors.body && (
          <p className="text-red-500 text-sm">{errors.body.message}</p>
        )}
        <Button type="submit">投稿</Button>
      </form>
      <h2 className="text-xl font-semibold mb-2">投稿一覧</h2>
      {loading ? (
        <p>読み込み中...</p>
      ) : (
        posts.map((post) => (
          <Card key={post.id} className="mb-2">
            <CardHeader>
              <CardTitle>{post.title}</CardTitle>
            </CardHeader>
            <CardContent>
              <div>{post.body}</div>
              <div className="text-xs text-gray-500 mt-2">{post.created_at}</div>
            </CardContent>
          </Card>
        ))
      )}
    </div>
  );
}

export default App;
